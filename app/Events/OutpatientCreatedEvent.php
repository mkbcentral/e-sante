 <?php
    namespace App\Events;
    use App\Models\OutpatientBill;
    use Illuminate\Broadcasting\Channel;
    use Illuminate\Broadcasting\InteractsWithSockets;
    use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
    use Illuminate\Foundation\Events\Dispatchable;
    use Illuminate\Queue\SerializesModels;


    class OutpatientCreatedEvent implements ShouldBroadcast
    {
        use Dispatchable, InteractsWithSockets, SerializesModels;

        public ?OutpatientBill $outpatientBill;

        /**
         * Create a new event instance. 0976720142
         */
        public function __construct(OutpatientBill $outpatientBill)
        {
            $this->outpatientBill = $outpatientBill;
        }

        /**
         * Get the channels the event should broadcast on.
         *
         * @return array<int, \Illuminate\Broadcasting\Channel>
         */
        public function broadcastOn(): array
        {
            return [
                new Channel('afia-sys'),
            ];
        }
        /**
         * broadcast event bill created
         */
        public function broadcastAs()
        {
            return 'bill-created';
        }
    }
