<?php

use Google\Client;
use Google\Service\Oauth2;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;

class LoginController extends Controller
{
    public function handleGoogleCallback(Request $request)
    {
        // Create a new instance of the Google API client
        $client = new Client();
        
        // Set the client ID, client secret, redirect URI, and access type
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(url('/auth/google/callback'));
        $client->setAccessType('offline');
        
        // Retrieve the authorization code from the callback request
        $code = $request->input('code');
        
        // Exchange the authorization code for an access token
        $token = $client->fetchAccessTokenWithAuthCode($code);
        
        // Save the access token to the database or session for later use
        $accessToken = $token['access_token'];
        $refreshToken = isset($token['refresh_token']) ? $token['refresh_token'] : null;
        $expiresIn = $token['expires_in'];
        // save the access token details to the database or session
        
        // Use the access token to authenticate the user and fetch their profile information
        $oauth2 = new Oauth2($client);
        $userInfo = $oauth2->userinfo->get();
        
        // Create or update the user in your database using the profile information
        $user = User::updateOrCreate(
            ['email' => $userInfo->email],
            ['name' => $userInfo->name]
        );

        // Redirect the user to your application's home page or dashboard
        return redirect('/');
    }
}