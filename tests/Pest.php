<?php

use Timatic\SDK\TimaticConnector;

uses()->beforeEach(function () {
    $this->timatic = new TimaticConnector();
})->in(__DIR__);
