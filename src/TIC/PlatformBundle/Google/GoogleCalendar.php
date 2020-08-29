<?php

namespace TIC\PlatformBundle\Google;
class GoogleCalendar
{
    const APPLICATION_NAME =  'Google Calendar API PHP Quickstart';
    private $CREDENTIALS_PATH;
    private $CREDENTIALS_FILENAME;
    private $CLIENT_SECRET_PATH;
    private $SCOPES;

    public function __construct()
    {
        $this->SCOPES = implode(' ', array(\Google_Service_Calendar::CALENDAR));
        $this->CREDENTIALS_FILENAME = 'calendar-php-quickstart.json';
        $this->CREDENTIALS_PATH = __DIR__ . DIRECTORY_SEPARATOR . '.credentials';
        $this->CLIENT_SECRET_PATH = __DIR__ . DIRECTORY_SEPARATOR . '.credentials' . DIRECTORY_SEPARATOR . 'client_secret.json';
    }

    /**
     * @param bool $init
     * @return \Google_Client
     * @throws \Exception
     */
    function getClient($init = false) {
        $client = new \Google_Client();
        $client->setApplicationName(self::APPLICATION_NAME);
        $client->setScopes($this->SCOPES);
        $client->setAuthConfigFile($this->CLIENT_SECRET_PATH);
        $client->setAccessType('offline');

        // Load previously authorized credentials from a file.
        $credentialsPath = realpath(join(DIRECTORY_SEPARATOR, array($this->CREDENTIALS_PATH, $this->CREDENTIALS_FILENAME)));
        if (file_exists($credentialsPath)) {
            $accessToken = file_get_contents($credentialsPath);
        } else {
            if (!$init) {
                throw new \Exception("Contact admin ASAP");
            }
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));

            // Exchange authorization code for an access token.
            $accessToken = $client->authenticate($authCode);

            // Store the credentials to disk.
            $path_filename = join(DIRECTORY_SEPARATOR, array(realpath($this->CREDENTIALS_PATH), $this->CREDENTIALS_FILENAME));
            file_put_contents($path_filename, $accessToken);
            printf("Credentials saved to %s\n", $path_filename);
        }
        $client->setAccessToken($accessToken);

        // Refresh the token if it's expired.
        if ($client->isAccessTokenExpired()) {
            $client->refreshToken($client->getRefreshToken());
            file_put_contents($credentialsPath, $client->getAccessToken());
        }
        return $client;
    }
}