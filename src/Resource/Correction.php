<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\Correction\PatchCorrectionRequest;
use Timatic\SDK\Requests\Correction\PostCorrectionsRequest;

class Correction extends BaseResource
{
    public function postCorrections(\Timatic\SDK\Foundation\Model|array|null $data = null): Response
    {
        return $this->connector->send(new PostCorrectionsRequest($data));
    }

    public function patchCorrection(string $correction, \Timatic\SDK\Foundation\Model|array|null $data = null): Response
    {
        return $this->connector->send(new PatchCorrectionRequest($correction, $data));
    }
}
