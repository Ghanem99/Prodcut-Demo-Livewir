namespace App\Services;

class FlashService
{
    public function success($message)
    {
        session()->flash('success', $message);
    }

    public function error($message)
    {
        session()->flash('error', $message);
    }
}