<?php

namespace App\Library;

class FtpUtil {

    private $stream = null;
    private $config = array();

    public function __construct($config = array()) {
        $this->config = array_merge(array(
             'host' => '127.0.0.1',
             'port' => '21',
             'user' => '',
             'pass' => '',
             'timeout' => '30',
         ), $config);
    }

    public function connect($reconnect = false) {
        if (null == $stream || $reconnect) {
            $this->stream = @ftp_connect($this->config['host'], $this->config['port'], $this->config['timeout']);
        }

        if (empty($this->stream)) {
            throw new \Exception(sprintf("连接FTP服务器[%s]失败", $this->config['host']));
        }

        if (!empty($this->config['user'])) {
            $result = @ftp_login($this->stream, $this->config['user'], $this->config['pass']);
            if (empty($result)) {
                throw new \Exception(sprintf("账号[%s]登录FTP服务器失败", $this->config['user']));
            }
        }
    }

    public function ls($dir) {
        return @ftp_nlist($this->stream, $dir);
    }

    public function cd($dir) {
        return @ftp_chdir($this->stream, $dir);
    }

    public function mkdir($dir, $recursive = false) {
        if (!$recursive) {
            return @ftp_mkdir($this->stream, $dir);
        }

        $nodes = explode('/', $dir);
        for ($index = 0; $index < count($nodes); $index ++) {
            $path = $nodes[$index] . '/';
            if (!$this->cd($path)) {
                @ftp_mkdir($this->stream, $path);
            }
        }
    }

    public function del($file, $recursive = false) {
        if (!$recursive) {
            return @ftp_delete($this->stream, $file);
        }

        if (!@ftp_delete($this->stream, $file)) {
            foreach ($this->ls($file) as $item) {
                $this->del($item, $recursive);
            }
            @ftp_rmdir($this->stream, $file);
        }
    }

    public function put($remote, $local, $autoMkdir = false) {
        if ($autoMkdir) {
            $nodes = explode('/', trim($remote));
            array_pop($nodes);

            $path = implode('/', $nodes);
            $this->mkdir($path);
        }

        return @ftp_put($this->stream, $remote, $local, FTP_BINARY);
    }

    public function get($remote, $local) {
        return @ftp_get($this->stream, $local, $remote, FTP_BINARY);
    }

    public function __destruct() {
        if (!empty($this->stream)) {
            @ftp_close($this->stream);
        }

        $this->stream = null;
    }

}
