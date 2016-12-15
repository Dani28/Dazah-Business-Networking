<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 |--------------------------------------------------------------------------
 | Dazah OAuth Credentials
 |--------------------------------------------------------------------------
 |
 | Specify your Dazapp's OAuth credentials
 | You can register a new Dazapp application at https://www.dazah.com/apps/register
 |
 */

$config = array(
    'client_id' => 'b',
    'client_secret' => 'foo bar baz bat blah blah blah',
    'scope' => 'profile_read,conversations_read,conversations_write'            
);