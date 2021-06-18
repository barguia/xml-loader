<?php

namespace App\Jobs;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Models\{XMLFile, XMLFileFail};
use Storage;
use Illuminate\Support\Facades\Redis;


class ProcessXMLFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $xmlFile;


    protected $serializer;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(XMLFile $xmlFile)
    {
        $this->xmlFile = $xmlFile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $redis = Redis::connection();
        $redis->set('user_details', json_encode([
                'first_name' => 'Alex',
                'last_name' => 'Richards'
            ])
        );
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);

        try {
            $dataFile = Storage::get($this->xmlFile->file_name);
            $jsonData = json_encode($this->serializer->decode($dataFile, 'xml'));
            $redis->set('xml:json:'.$this->xmlFile->id, $jsonData);

            $this->xmlFile->redis_key = 'xml:json:'.$this->xmlFile->id;
            $this->xmlFile->finalized_at = date('Y-m-d H:i;s');
            $this->xmlFile->success = 1;
            $this->xmlFile->update();

        } catch (\Exception $e) {
            $this->xmlFile->success = 0;
            $this->xmlFile->failures()->save(new XMLFileFail([
                "xml_file_id" => $this->xmlFile->id,
                "fail" => 'Fail to process xml file'
            ]));
            $this->xmlFile->finalized_at = date('Y-m-d H:i;s');
            $this->xmlFile->update();
        }
    }
}
