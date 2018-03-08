<?php

namespace Nilnice\Phalcon\Http;

use Nilnice\Phalcon\Constant\Service;
use Nilnice\Phalcon\Exception\Exception;

class Response extends \Phalcon\Http\Response
{
    /**
     * Set exception or error content.
     *
     * @param \Exception $e
     * @param bool       $devMode
     */
    public function setExceptionContent(\Exception $e, $devMode = false) : void
    {
        /** @var \Nilnice\Phalcon\Http\Request $request */
        $request = $this->getDI()->get(Service::REQUEST);

        /** @var \Nilnice\Phalcon\Support\Message $message */
        $message = $this->getDI()->has(Service::MESSAGE)
            ? $this->getDI()->get(Service::MESSAGE) : null;

        $code = $e->getCode();
        $msg = $e->getMessage();

        if ($message && $message->has($code)) {
            $default = $message->get($code);
            $code = $default['code'];

            if (! $message) {
                $msg = $default['message'];
            }
        }

        $info = [];
        $msg = $msg ?? 'Unknown exception';
        if ($e instanceof Exception && $e->getUserInfo() !== null) {
            $info['userInfo'] = $e->getUserInfo();
        }

        if ($devMode === true) {
            $method = $request->getMethod();
            $uri = $request->getURI();
            $devInfo = [
                'file'          => $e->getFile(),
                'line'          => $e->getLine(),
                'message'       => $msg,
                'request'       => $method . ' ' . $uri,
                'previous'      => $e->getPrevious(),
                'trace'         => $e->getTrace(),
                'traceAsString' => $e->getTraceAsString(),
            ];

            if ($e instanceof Exception && $e->getDevInfo() !== null) {
                $devInfo['devInfo'] = $e->getDevInfo();
            }
            $info['devInfo'] = $devInfo;
        }

        $content = [
            'code'    => $code,
            'message' => $msg,
            'data'    => $info,
        ];
        $this->setJsonContent($content);
        $this->setStatusCode(500);
    }

    /**
     * Set JSON content.
     *
     * @param mixed $content
     * @param int   $jsonOptions
     * @param int   $depth
     *
     * @return \Phalcon\Http\Response|void
     */
    public function setJsonContent($content, $jsonOptions = 0, $depth = 512)
    {
        parent::setJsonContent($content, $jsonOptions, $depth);

        $value = md5($this->getContent());
        $this->setContentType('application/json', 'UTF-8');
        $this->setHeader('E-Tag', $value);
    }
}
