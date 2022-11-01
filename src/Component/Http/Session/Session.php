<?php
namespace Laventure\Component\Http\Session;


/**
 * Session
*/
class Session implements SessionInterface
{

    /**
     * @var string
    */
    protected $flashKey;




    /**
     * @param string $flashKey
    */
    public function __construct(string $flashKey = 'session.flash')
    {
         $this->flashKey = $flashKey;
    }





    /**
     * @return bool
    */
    public function start(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            return session_start();
        }

        return false;
    }




    /**
     * @return bool
    */
    public function abort(): bool
    {
         return session_abort();
    }






    /**
     * @param string $name
     * @param $value
     * @return void
    */
    public function set($name, $value): self
    {
        $_SESSION[$name] = $value;

        return $this;
    }





    /**
     * @param array $sessions
     * @return void
     */
    public function add(array $sessions)
    {
        foreach ($sessions as $name => $value) {
            $this->set($name, $value);
        }
    }




    /**
     * @param string $name
     * @return bool
     */
    public function has($name): bool
    {
        return isset($_SESSION[$name]);
    }




    /**
     * @param string $name
     * @param $default
     * @return mixed|null
     */
    public function get($name, $default = null)
    {
        return $_SESSION[$name] ?? $default;
    }




    /**
     * @param string $name
     * @return void
     */
    public function forget($name)
    {
        unset($_SESSION[$name]);
    }






    /**
     * Remove all sessions
     *
     * @return void
    */
    public function destroy()
    {
        $_SESSION = [];
        session_destroy();
    }





    /**
     * @return array
    */
    public function all(): array
    {
        return $_SESSION;
    }




    /**
     * @param string $flashKey
     * @return $this
    */
    public function setFlashKey(string $flashKey): self
    {
        $this->flashKey = $flashKey;

        return $this;
    }





    /**
     * @param string $name
     * @param string $message
     * @return Session
    */
    public function setFlash($name, $message): self
    {
        $_SESSION[$this->flashKey][$name][] = $message;

        return $this;
    }




    /**
     * @param string $name
     * @return array|mixed
    */
    public function getFlash($name)
    {
        return $_SESSION[$this->flashKey][$name] ?? [];
    }




    /**
     * @return array|mixed
    */
    public function getFlashes()
    {
        return $_SESSION[$this->flashKey] ?? [];
    }





    /**
     * @param string $path
     * @return $this
    */
    public function saveTo(string $path): self
    {
        ini_set('session.save_path', $path);
        ini_set('session.gc_probability', 1);

        return $this;
    }






    /**
     * @return string
    */
    public function savePath(): string
    {
        return session_save_path();
    }
}