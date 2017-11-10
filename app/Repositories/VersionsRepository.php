<?php

namespace App\Repositories;

use App\Models\Version;
use App\Repositories\Interfaces\BaseRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use \Illuminate\Database\Eloquent\Builder;

/**
 * Class VersionsRepository
 *
 * @package App\Repositories
 */
class VersionsRepository implements BaseRepository
{
    CONST MIN_VERSION = '0.1.0';

    /**
     * @param array $data
     *
     * @return Version
     */
    public function create(array $data)
    {
        if (empty($data['repository_version'])) {
            $data['repository_version'] = $this->getNextVersionByRepo(
                $data['repository']
            );
        } else {
            $data['repository_version'] = $this->validateVersionForRepo(
                $data['repository_version'],
                $data['repository']
            );
        }
        if (empty($data['deployment_date'])) {
            $data['deployment_date'] = Carbon::now();
        } else {
            $data['deployment_date'] = Carbon::parse($data['deployment_date']);
        }
        $obj = new Version();
        $obj->fill($data);
        $obj->save();

        return $obj;
    }

    /**
     * @param string $repository
     *
     * @return string
     */
    public function getNextVersionByRepo(string $repository)
    {
        $versions = Version::where('repository', $repository)->orderBy(
            'repository_version',
            'DESC'
        )->get();

        if ($versions->isEmpty()) {
            return self::MIN_VERSION;
        }

        return $this->updateVersion($versions->first()->repository_version);
    }

    /**
     * @param string $currentVersion
     *
     * @return string
     */
    private function updateVersion(string $currentVersion)
    {
        $parts = explode('.', $currentVersion);

        if (isset($parts[count($parts) - 1]) && $parts[count($parts) - 1] < 9) {
            $parts[count($parts) - 1]++;
        } elseif (isset($parts[count($parts) - 2]) && $parts[count($parts) - 2] < 9) {
            $parts[count($parts) - 2]++;
            if (isset($parts[count($parts) - 1])) {
                $parts[count($parts) - 1] = 0;
            }
        } else {
            $parts[key(reset($parts))]++;

            return current($parts).'.0.0';
        }

        return implode('.', $parts);
    }

    /**
     * @param string $version
     * @param string $repository
     *
     * @return string
     */
    private function validateVersionForRepo(string $version, string $repository)
    {
        $versions = Version::where('repository_version', $version)
            ->where('repository', $repository)
            ->first();

        if (empty($versions)) {
            return $version;
        }

        return $this->getNextVersionByRepo($repository);
    }

    /**
     * @param int   $id
     * @param array $data
     *
     * @return Version
     */
    public function update(int $id, array $data)
    {
        $obj = $this->find($id);
        $obj->fill($data);
        $obj->save();

        return $obj;
    }

    /**
     * @param int $id
     *
     * @return Version
     */
    public function find(int $id)
    {
        return Version::find($id);
    }

    /**
     * @param int $id
     *
     * @throws ModelNotFoundException
     * @return bool
     */
    public function delete(int $id)
    {
        $obj = $this->find($id);

        if (empty($obj)) {
            throw new ModelNotFoundException("Version not found!");
        }

        $obj->delete();

        return true;
    }

    /**
     * @return Collection
     */
    public function all()
    {
        return Version::all();
    }

    /**
     * @return Builder
     */
    public function getQuery()
    {
        return Version::query();
    }
}