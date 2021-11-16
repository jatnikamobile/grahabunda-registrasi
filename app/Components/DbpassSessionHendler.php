<?php
namespace App\Components;
// we have an Eloquent model that allows using the session table with the querybuilder methods and eloquent fluent interface- read only!
use App\Models\Sessions;
use Session;
// use the provided database session handler to avoid too much duplicated effort.
use Illuminate\Session\DatabaseSessionHandler;
class DbpassSessionHandler extends DatabaseSessionHandler
{
    /**
     * {@inheritdoc}
    */
    public function read($sessionId)
    {
        $session = (object) $this->getQuery()->find($sessionId);
        
        if ($this->expired($session)) {
            echo 'read ex true';
            dd($session);
            $this->exists = true;

            return '';
        }

        if (isset($session->payload)) {
            echo 'read ex false';
            dd($session);
            $this->exists = true;

            return base64_decode($session->payload);
        }

        return '';
    }

     /**
     * Determine if the session is expired.
     *
     * @param  \stdClass  $session
     * @return bool
     */
    protected function expired($session)
    {
        return isset($session->last_activity) &&
            $session->last_activity < Carbon::now()->subMinutes($this->minutes)->getTimestamp();
    }
    
    /**
     * {@inheritDoc}
     */
    public function write($sessionId, $data)
    {
        echo 'write';
        $user_id = (auth()->check()) ? auth()->user()->id : null;
        dd($user_id);
        if ($this->exists) {
            $this->getQuery()->where('id', $sessionId)->update([
                'payload' => base64_encode($data), 'last_activity' => time(), 'user_id' => $user_id,
            ]);
        } else {
            $this->getQuery()->insert([
                'id' => $sessionId, 'payload' => base64_encode($data), 'last_activity' => time(), 'user_id' => $user_id,
            ]);
        }

        $this->exists = true;
    }

    /**
     * The destroy method can be called at any time for a single session. Ensure that our related records are removed to prevent foreign key constraint errors.
     *
     * {@inheritdoc}
     */
    public function destroy($sessionId)
    {
        dd($sessionId);
        $session = $this->getQuery()->where('id', $sessionId);
        // tidy up any orphaned records by this session going away.
        $sessionModel = Sessions::find($sessionId);
        foreach ($sessionModel->myModels as $model) {
            $sessionModel->myModels()->detach($model->id);
            $model->delete();
        }
        $session->delete();
    }
    /**
     * Replicate the existing gc behaviour but call through to our modified destroy method instead of the default behaviour
     *
     * {@inheritdoc}
     */
    public function gc($lifetime)
    {
        dd($sessionId);
        $sessions = $this->getQuery()->where('last_activity', '<=', time() - $lifetime)->get();
        foreach ($sessions as $session) {
            $this->destroy($session->id);
        }
    }
}