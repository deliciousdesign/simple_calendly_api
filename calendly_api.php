<?php
class calendly_api {
	var $api_key;
	var $return_array = true; # true = json array / false = json object
	var $root = 'https://calendly.com/api/v1/';
	public function __construct($api_key) {
		$this->api_key = $api_key;
	}

	# Test Authentication Token
	public function test() {
		return $this->api('get', 'echo');
	}
	# Create A Webhook Subscription
	public function create_webhook_subscription($params) {
		return $this->api('post', 'hooks', $params);
	}
	# Get Webhook Subscription
	public function get_webhook_subscription($hook_id) {
		return $this->api('get', 'hooks/' . $hook_id);
	}
	# Get List of Webhook Subscriptions
	public function get_list_of_webhook_subscriptions() {
		return $this->api('get', 'hooks');
	}
	# Delete Webhook Subscription
	public function delete_webhook_subscription($hook_id) {
		return $this->api('delete', 'hooks/' . $hook_id);
	}


	# Base API call.
	public function api($method, $endpoint, $postfields='') {
		# curl --header "X-TOKEN: <your_token>" https://calendly.com/api/v1/hooks
		$ch = curl_init();

		# Base URL + Endpoint
		$url = $this->root . $endpoint;


		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		switch (strtolower($method)) {
			case 'post':
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
			break;
			case 'delete':
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
			break;

			case 'get':
			default:
				# Do nothing
			break;
		}

		# Custom headers with authorization token
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'X-TOKEN: ' . $this->api_key
		));

		$data = curl_exec($ch);

		if (curl_error($ch)) {
			curl_close($ch);
			return ['ErrorCode'=>curl_errno($ch), 'ErrorMessage'=>curl_error($ch)];
		}
		else {
			curl_close($ch);

			return json_decode($data, $this->return_array);
		}
	}
}
