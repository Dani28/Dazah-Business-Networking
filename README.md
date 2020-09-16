# Dazah Business Networking tool

This app is built on top of the DaniWeb Connect API. The API is a user recommendation engine and chat network designed to power communities and lead generation platforms.
Members of DaniWeb-powered communities enjoy an ability to discover, connect and message each other through a sophisticated matching algorithm.

This app finds your top 100 best matches, sorted by relevancy.
Browse the elevator pitches of your matches and determine instantly whether there is potential synergy or not.
Each time you choose to meet or mute someone, a new match is introduced.

This application only taps into a few components of the Dazah API.
It can be used out-of-the-box, integrated with your exisiting business model, or you can add additional functionality from the Dazah API.

**Check out [https://www.daniweb.com/connect/developers](https://www.daniweb.com/connect/developers) for complete API documentation**

## Prerequisite:

Register a new Daniapp (DaniWeb application) at [https://www.daniweb.com/connect/apps/register](https://www.daniweb.com/connect/apps/register)

Note: You will need to associate your new Daniapp with a new or existing Audience Segment.
You can create an empty collection of users, or you can import our audience segment (see below).
 
## To Install:

1. Upload all files to the document root of a PHP-capable web server (nginx, apache, etc.)
2. Modify line 26 of `/application/config/config.php` and specify your website's URL
3. Modify lines 15 and 16 of `/application/config/dazah.php` with your Daniapp API credentials

## Daniapp Directory:

To be listed in the Daniapp Directory:

1. Go to [https://www.daniweb.com/connect/apps/register](https://www.daniweb.com/connect/apps/register)
2. Click the Modify link next to the appropriate Daniapp
3. Specify an Application URL of http://www.example.com/index.php (or https:// if you have an SSL certificate)
4. Check `profile_read`, `conversations_read`, and `conversations_write` for Scope Requested
5. Check 'Production' for Application Live?

## To Import Our Audience:

1. Go to [https://www.daniweb.com/connect/audiences/register](https://www.daniweb.com/connect/audiences/register)
2. Import our audience segment into your account with the Public Key:

		AgJjKpZXtW4eBTBkdz2N9BhuehreVQztEcykojX4npD3hD7Qll355IptQO7dXbfgK98gnEJE8Bkcxxq44i8odc6pQLZZKkDrAquBlWq1NU4gyaFiLMzApcqUsQ7WSZfEAPaB6FldqyEi43j7oP9r6haHGQGcntxKZiU1MmWSpQCQnQjHWuCrLZETyIzrl68o29NIjdv4UArMQAHNgZSzIRcJlxjJjREbSsDRdeyqjVbpOxxgk2Rx5Xs2NKKtpcOgcvw3Yl60d5i72NpJqKpKM8PQhIf3sf2FfWYiy1dckLqXjZJ8Ej3ptd0qmVgqlOWwy2nwgdembOw2fYGQa4Afj2pT

3. Modify your Daniapp record to include the *Pro Networkers* audience