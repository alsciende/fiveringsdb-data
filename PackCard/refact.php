<?php

$slots = json_decode(file_get_contents('core.json'), true);
usort($slots, function ($a, $b) { return $a['card_id'] <=> $b['card_id']; });
print(json_encode($slots, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

