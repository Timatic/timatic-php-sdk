<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Hydration\Model;
use Timatic\SDK\Requests\Correction\PatchCorrectionRequest;
use Timatic\SDK\Requests\Correction\PostCorrectionsRequest;

class Correction extends BaseResource
{
    public function postCorrections(Model|array|null $data = null): Response
    {
        return $this->connector->send(new PostCorrectionsRequest($data));
    }

    public function patchCorrection(string $correctionId, Model|array|null $data = null): Response
    {
        return $this->connector->send(new PatchCorrectionRequest($correctionId, $data));
    }
}
