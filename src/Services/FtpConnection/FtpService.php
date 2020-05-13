<?php


namespace App\Services\FtpConnection;


class FtpService implements FtpConnector
{
    private $ftp_server;
    private $ftp_username;
    private $ftp_userpass;

    /**
     * FtpService constructor.
     * @param $ftp_server
     * @param $ftp_username
     * @param $ftp_userpass
     */
    public function __construct($ftp_server,
                                $ftp_username,
                                $ftp_userpass
    )
    {
        $this->ftp_server=$ftp_server;
        $this->ftp_username=$ftp_username;
        $this->ftp_userpass=$ftp_userpass;
    }

    public function connectToFtp()
    {
        $ftp_conn=ftp_connect($this->ftp_server);
        $login=ftp_login($ftp_conn, $this->ftp_username, $this->ftp_userpass);
        $list = ftp_nlist($ftp_conn, ".");

        return $ftp_conn;

    }

    /**
     * @param $local_file
     * @param $arg
     * @return string
     */
    public function downloadFtp($local_file, $arg){
        if (ftp_get($this->connectToFtp(), $local_file, $arg, FTP_BINARY)) {
            return "Successfully written to $arg\n";
        }
    }

    /**
     * @param $remote_file
     * @param $arg
     * @return string
     */
    public function uploadFtp($remote_file, $arg){
        if (ftp_put($this->connectToFtp(), $remote_file, $arg, FTP_ASCII)) {
            return "successfully uploaded $arg\n";
        }
    }
}