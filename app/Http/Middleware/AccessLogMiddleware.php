<?php

namespace App\Http\Middleware;

use App\Models\AccessLog;
use Carbon\Carbon;
use Closure;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class AccessLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $traceId = Str::uuid();
        $request->headers->set('X-Trace-Id', $traceId);

        $accessRequest = [
            'trace_id' => $traceId,
            'path' => $request->path(),
            'method' => $request->method(),
            'body' => json_encode($request->all(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
        ];

        $respone = $next($request);

        $accessRespone = [
            'response' => $respone->getContent()
        ];

        $log = array_merge($accessRequest, $accessRespone);
        Log::debug('access_log', $log);
        $this->saveLog($log);

        return $respone;
    }

    /**
     * save log
     * sync or queue，here use sync
     * @param $log
     * @return void
     */
    protected function saveLog($log)
    {
        try {
            $accessLogModel = new AccessLog();
            $newTableName = Str::snake(Str::pluralStudly(class_basename(AccessLog::class))) . '_' . Carbon::today()->toDateString();
            $accessLogModel->setTable($newTableName);
            if (!Schema::hasTable($newTableName)) {
                $this->createTable($newTableName);
            }
            $accessLogModel->setRawAttributes($log, true);
            $accessLogModel->save();
        } catch (\Throwable $e) {
            var_dump($e->getMessage());
            Log::debug('saveLog err');
        }
    }

    /**
     * @param $tableName
     * @return void
     */
    protected function createTable($tableName)
    {
        Cache::lock('create_access_log', 10)->get(function () use ($tableName) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->id('log_id');
                $table->string('trace_id', 36)->nullable(false)->default('')->comment('请求id')->index();
                $table->string('method', 8)->nullable(false)->default('')->comment('请求方法');
                $table->string('path', 256)->nullable(false)->default('')->comment('请求路径');
                $table->mediumText('body')->comment('请求数据');
                $table->mediumText('response')->comment('响应内容');
                $table->timestamps();
            });
        });
    }
}
