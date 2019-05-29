# simple_calendly_api
A simple PHP library for Calendly API

Usage:

$calendly_api = new calendly_api('YOUR_API_KEY_HERE');
$result = $calendly_api->test();

print_r($result);


# Get your API key
https://developer.calendly.com/docs/getting-started

# Really simple list of functions

$calendly_api->test();

$calendly_api->create_webhook_subscription($params);

$calendly_api->get_webhook_subscription($hook_id);

$calendly_api->get_list_of_webhook_subscriptions();

$calendly_api->delete_webhook_subscription($hook_id);
