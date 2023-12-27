<?php

namespace App\Events;

use App\Models\Advertisement;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class AdvertisementDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }

    public function handle(Advertisement $advertisement)
    {
        $photos = $advertisement->photos;
        if ($photos) {
            foreach ($photos as $photo) {
                Storage::delete($photo->URL);
            }
            $advertisement->photos()->delete();
        }
        $advertisement->user()->dissociate();
        $advertisement->categoryFields()->detach();
    }
}
