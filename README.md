# Build your own professional social network and lead generation platform

Dazah is a business-oriented social messaging platform designed to power communities.
Members of Dazah-powered communities enjoy an ability to discover, connect and message each other through a sophisticated matching algorithm.

From networking groups to job boards, all Dazapps have one thing in common:
they're designed to match you with the people you otherwise wouldn't have found and yet are perfectly targeted to have synergy with,
and they all work seamlessly through a single sign-in with your Dazah profile.

**A real-world demo of this application can be reached at http://app.dazah.com**

This application, built on top of the robust Dazah API, leverages the Dazah matching algorithm to find your top 100 best matches, sorted by relevancy.
Browse the elevator pitches of your matches and determine in seconds whether there is potential synergy or not.
Each time you choose to meet or mute someone, a new match is introduced.
Existing social networks are designed to help you stay in touch with people you already know. We're different.
We walk you through the entire introduction process so that you can then participate in a real time chat through our platform,
or take the conversation offline or into your preferred CRM tool.

This application only taps into a few components of the Dazah API.
It can be used out-of-the-box, integrated with your exisiting business model, or you can add additional functionality from the Dazah API.

**Check out https://www.dazah.com/developers for complete API documentation**

### Instantly generate revenue.

Dazah charges a small micropayment (typically from $0 to $5) for users to introduce themselves to new connections.
The fee is algorithmically determined based on how much the user being connected with has synergy with the end-user,
as well as how many connections the end-user has already made over the past day. In many ways, this acts as a barrier
against users being solicited by those irrelevant to them, or by marketers attempting to cast a very wide net.

There are a limited number of free connections per day that can made with users who have been algorithmically determined
to be best matches for the end-user, making Dazah a "freemium" service. In practice, it's free for end-users to be able
to initiate new connections a few times each day with their best matches, and engage in unlimited communication with
users they are already connected with or participate within group discussions. However, power users who want to take
advantage of being exposed to the entire Dazah universe of users for the purposes of lead generation and networking must cross a pay wall. 

The API has been designed in such a way so that the payment may come either directly from the end-user of your application,
or from the application itself. In the case of the latter, you may choose to have your application pass the individual
fee onto your end-user, charge a premium, function as a flat-fee SaaS, absorb the costs, etc.

### Effortlessly search by an infinite variation of data points.

Leverage the power of being a part of a something larger than you are.
Perform advanced filtering against metadata you've attached to users and messages or access public metadata that other Dazapps have made available.
Learn more about your users by pooling data with other Dazapps that have overlapping audiences, and perform complex searches against the entire Dazah universe.

## Prerequisite:

Register a new Dazapp (Dazah application) at https://www.dazah.com/apps/register

To instantly generate revenue, click on the Modify link next to your newly registered Dazapp and fill out your PayPal email address.
You will automatically receive a commission, paid out weekly, each time users of your application pay to connect.
 
## To Install:

1. Upload all files to the document root of a PHP-capable web server (nginx, apache, etc.)
2. Modify line 26 of `/application/config/config.php` and specify your website's URL
3. Modify lines 15 and 16 of `/application/config/dazah.php` with your Dazapp API credentials