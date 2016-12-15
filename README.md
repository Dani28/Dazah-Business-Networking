# Build your own "Tinder-for-Business" lead generation platform

This app is built on top of the Dazah API. Dazah is a user recommendation engine and chat network designed to power communities and lead generation platforms.
Members of Dazah-powered communities enjoy an ability to discover, connect and message each other through a sophisticated matching algorithm.

**A real-world demo of this application can be reached at http://app.dazah.com**

This app finds your top 100 best matches, sorted by relevancy.
Browse the elevator pitches of your matches and determine instantly whether there is potential synergy or not.
Each time you choose to meet or mute someone, a new match is introduced.

This application only taps into a few components of the Dazah API.
It can be used out-of-the-box, integrated with your exisiting business model, or you can add additional functionality from the Dazah API.

**Check out https://www.dazah.com/developers for complete API documentation**

## Prerequisite:

Register a new Dazapp (Dazah application) at https://www.dazah.com/apps/register

Note: You will need to associate your new Dazapp with a new or existing Audience Segment.
You can create an empty collection of users, or you can import our audience segment (see below).
 
## To Install:

1. Upload all files to the document root of a PHP-capable web server (nginx, apache, etc.)
2. Modify line 26 of `/application/config/config.php` and specify your website's URL
3. Modify lines 15 and 16 of `/application/config/dazah.php` with your Dazapp API credentials

## Dazapp Directory:

To be listed in the Dazapp Directory:

1. Go to https://www.dazah.com/apps/register
2. Click the Modify link next to the appropriate Dazapp
3. Specify an Application URL of http://www.example.com/index.php (or https:// if you have an SSL certificate)
4. Check `profile_read`, `conversations_read`, and `conversations_write` for Scope Requested
5. Check 'Production' for Application Live?

## To Import Our Audience:

1. Go to https://www.dazah.com/bubbles/register
2. Import our audience segment into your account with the Public Key:

	6e796a2f4a4b456f77342f2b7663676d31336879775757314c34767463565652724f782f5558756c6b4e756437654c793954575a484c426655475274466571725070573946626f6138324e48347674366e7a672f31384b70777a645a6853595848414358776f774e4c772b436a504177624665647750376a304f453134497a6e5570637a74667668624a574e6842673977565a6c4b6561623773373774657a68342b6866646e434d6872493d
	
3. Modify your Dazapp record to include the *Business Network* audience