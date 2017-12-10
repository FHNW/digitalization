<?php
/**
 * Overwrite this class to use a specific file transfer protocol
 *
 * @author Patrick Meyer
 * @since d#9
 */
class SFTPLibHandler extends FileTransferStub {

    /**
     * Connection handle
     */
    protected $sftp = null;             //ID of the ssh connection
    protected $connected = false;       //Set to true after a successful login

    /**
     * Connects to the server via using $host.
     *
     * @return TRUE, if connection to host can be established.
     */
    function connect() {

        global $CFG;
        set_include_path(get_include_path() . PATH_SEPARATOR . $CFG->dirroot . '/mod/digitalization/filetransfer/ext/phpseclib');
        require("Net/SFTP.php");

        //Open connection to the remote host via SSH
        $this->sftp = new Net_SFTP($this->host);

        if($this->sftp) {
            return true;
        }

        return false;
    }

    /**
     * Creates a session with the host.
     *
     * @return session
     */
    function login() {

        if ($this->sftp) {
            $this->connected = $this->sftp->login($this->user, $this->pwd);
        }

        if ($this->connected) {
            return true;
        }
        return false;
    }

    /**
     * Lists the file names of a directory.
     *
     * @param $path Path to the directory
     * @return List of file names
     */
    function listDir($path) {
        $this->sftp->chdir($path);
        return $this->sftp->nlist();
    }

    /**
     * Receives the file content from the remote location and saves it locally.
     *
     * @param $remotePath Remote file path
     * @param $localFileHandle Local file path handle
     * @return TRUE, if download and file writing succeeded
     */
    function recvFile($remotePath, $localFileHandle) {
        $success = false;

        if ($localFileHandle) {
            //Read the file content
            $remoteContent = $this->sftp->get($remotePath);

            if ($remoteContent) {
                //Write the file content to the local file, given by the $fileHandler
                if (fwrite($localFileHandle, $remoteContent)) {
                    $success = true;
                    fclose($localFileHandle);
                }
            }
        }

        return $success;
    }

    /**
     * Removes a remote file.
     *
     * @param $path File path
     * @return TRUE, if file could be deleted
     */
    function remFile($path) {
        return $this->sftp->delete($path);
    }

    /**
     * Close the session
     */
    function close() {
        /*if ($this->sftp) {
            $this->sftp->close();
        }*/
    }
}
?>
