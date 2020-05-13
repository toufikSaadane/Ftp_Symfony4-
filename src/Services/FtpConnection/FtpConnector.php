<?php


namespace App\Services\FtpConnection;


interface FtpConnector
{
    /**
     * @return mixed
     */
    public function connectToFtp();

    /**
     * @param $remote_file
     * @param $arg
     * @return mixed
     */
    public function uploadFtp($remote_file, $arg);

    /**
     * @param $local_file
     * @param $arg
     * @return mixed
     */
    public function downloadFtp($local_file, $arg);
}