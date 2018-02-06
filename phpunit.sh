#!/bin/bash
# 解决phpunit批量跑测试很慢的问题
# 将测试独立拆开一个个的跑，效率会有极大的提升

set -eo pipefail

for i in $(find tests -type f -name "*Test.php" | xargs -I {} basename {} .php)
do
    vendor/bin/phpunit --configuration phpunit.xml --filter $i
done