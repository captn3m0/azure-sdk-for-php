<?php

/**
 * LICENSE: Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * PHP version 5
 *
 * @category  Microsoft
 * @package   Tests\Unit\WindowsAzure\Common\Internal
 * @author    Azure PHP SDK <azurephpsdk@microsoft.com>
 * @copyright Microsoft Corporation
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/windowsazure/azure-sdk-for-php
 */

namespace Tests\Unit\WindowsAzure\Common\Internal;
use WindowsAzure\Common\Internal\OAuthRestProxy;
use WindowsAzure\Common\Internal\Resources;
use WindowsAzure\Common\Internal\Http\HttpClient;
use WindowsAzure\Common\Internal\MediaServicesSettings;
use Tests\Framework\TestResources;

/**
 * Unit tests for class OAuthRestProxy
 *
 * @category  Microsoft
 * @package   Tests\Unit\WindowsAzure\Common\Internal
 * @author    Azure PHP SDK <azurephpsdk@microsoft.com>
 * @copyright Microsoft Corporation
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @version   Release: @package_version@
 * @link      https://github.com/windowsazure/azure-sdk-for-php
 */
class OAuthRestProxyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers WindowsAzure\Common\Internal\OAuthRestProxy::getAccessToken
     * @covers WindowsAzure\Common\Internal\OAuthRestProxy::__construct
     */
    public function testGetAccessToken()
    {
        // Setup
        $channel            = new HttpClient();
        $uri                = Resources::MEDIA_SERVICES_OAUTH_URL;
        $connectionString   = TestResources::getMediaServicesConnectionString();
        $settings           = MediaServicesSettings::createFromConnectionString($connectionString);
        $scope              = Resources::MEDIA_SERVICES_OAUTH_SCOPE;

        // Test
        $proxy = new OAuthRestProxy($channel, $uri);
        $actual = $proxy->getAccessToken(Resources::OAUTH_GT_CLIENT_CREDENTIALS, $settings->getAccountName(), $settings->getAccessKey(), $scope);

        // Assert
        $this->assertNotNull($proxy);
        $this->assertNotNull($actual->getAccessToken());
        $this->assertGreaterThan(time(), $actual->getExpiresIn());
        $this->assertEquals($scope, $actual->getScope());
    }
}


