<?php
declare(strict_types=1);

use Kernel\Plugin\Const\Plugin;

return [
    Plugin::NAME => 'MyTokenPay',
    Plugin::AUTHOR => 'ai_dianpu',
    Plugin::DESCRIPTION => '使用本插件，你可以轻松接入TokenPay。',
    Plugin::VERSION => '1.0.0',
    Plugin::ARCH => Plugin::ARCH_CLI | Plugin::ARCH_FPM,
    Plugin::TYPE => Plugin::TYPE_PAY
];
