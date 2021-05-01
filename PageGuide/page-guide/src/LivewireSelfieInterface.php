<?php
namespace TallAndSassy\PageGuide;

interface LivewireSelfieInterface {
    // Misnomer, Modalness is determine by caller
    public function renderModalSelfie(array $asrParams);
}
