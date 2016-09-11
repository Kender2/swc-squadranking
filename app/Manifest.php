<?php
namespace App;

use Carbon\Carbon;
use File;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Manifest
 *
 * @property integer $version
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Manifest whereVersion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Manifest whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Manifest whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Manifest extends Model
{
    protected $content;
    protected $version;

    protected $primaryKey = 'version';
    public $incrementing = false;

    /**
     * @param mixed $content
     * @return Manifest
     */
    public function setContent($content)
    {
        $this->content = $content;
        $this->attributes['version'] = $content['version'];
        return $this;
    }


    public static function fromJsonString($jsonText) {
        $manifest = new Manifest();
        $manifest->setContent(json_decode($jsonText, true));
        $manifest->setCreatedAt(Carbon::parse($manifest->content['created']));
        return $manifest;
    }

    public static function fromFile($version) {
        $path = storage_path('app/manifests');
        $json = File::get($path . DIRECTORY_SEPARATOR . $version . '.json');
        return self::fromJsonString($json);
    }

    public static function latestVersion()
    {
        /** @var Manifest $manifest */
        $manifest = Manifest::orderBy('version', 'desc')->first();
        if ($manifest === null) {
            return 1;
        }
        return $manifest->getVersion();
    }

    /**
     * Compares two manifests.
     *
     * Returns any added or changed files with hashes.
     *
     * @param Manifest $otherManifest
     *   The manifest to compare to.
     *
     * @return array
     *   Hashes keyed by path.
     */
    public function compareTo(Manifest $otherManifest)
    {
        $changedHashes = [];
        foreach ($this->getHashes() as $path => $hash) {
            if (!$otherManifest->hasPath($path)) {
                $changedHashes[$path] = $hash;
            } elseif ($hash !== $otherManifest->getHash($path)) {
                $changedHashes[$path] = $hash;
            }
        }
        return $changedHashes;
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->attributes['version'];
    }

    /**
     * @return array
     */
    public function getHashes()
    {
        return $this->content['hashes'];
    }

    public function getHash($path)
    {
        return $this->content['hashes'][$path];
    }

    public function hasPath($path)
    {
        $hashes = $this->getHashes();
        return array_key_exists($path, $hashes);
    }

}
