<?php

/* 
 * Copyright 2021 alessioferri.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

use PHPUnit\Framework\TestCase;
use leaf\log\LoggerFile;

final class LogTest extends TestCase {

    public function testFilter(): void {
        $temp = fopen("logtest.log", 'w');
        $logger = new LoggerFile( $temp, LOG_ERR );
        $logger->info('Do whatever you want');
        $logger->error('ERROR');
        fclose( $temp );
        
        $content = file_get_contents('logtest.log');

        $this->assertEquals ( $content, 'ERROR' );
    }

    public function testInterpolate(): void {
        $temp = fopen("logtest.log", 'w');
        $logger = new LoggerFile( $temp, LOG_INFO );
        $logger->info('Do whatever you want {random}', [ 'random' => 'Gianluigi' ]);
        fclose( $temp );
        
        $content = file_get_contents('logtest.log');

        $this->assertEquals ( $content, 'Do whatever you want Gianluigi' );
    }

}
