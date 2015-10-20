<?php

namespace App\Http;

class Flash{
    public function create($title, $message, $type, $key = 'flash_message')
    {
        return session()->flash($key, [
            'title' => $title,
            'message' => $message,
            'type' => $type,
        ]);
    }

    public function info($title, $message)
    {
        return $this->create($title, $message, 'info');
    }

    public function success($title, $message)
    {
        return $this->create($title, $message, 'success');
    }

    public function error($title, $message)
    {
        return $this->create($title, $message, 'error');
    }

    public function warning($title, $message)
    {
        return $this->create($title, $message, 'warning');
    }

    public function overlay($title, $message, $type = 'success')
    {
        return $this->create($title, $message, $type, 'flash_message_overlay');
    }

    
}