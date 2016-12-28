<?php
require 'vendor/autoload.php';

$longOptions = [
    "instances:",
    "instance-type:",
    "allow-ssh-from:"
];

// get any options passed in on the command line
$options     = getopt("", $longOptions);

$header = [
    'AWSTemplateFormatVersion' => '2010-09-09'
];

$outputs = [
    'Outputs' => [
        'PublicIp' => [
            'Description' => 'Public IP address of the newly created EC2 instance',
            'Value' => [
                'Fn::GetAtt' => [
                    'EC2Instance',
                    'PublicIp'
                ]
            ]
        ]
    ]
];

$resources = getResources($options);

$template = [];

// create the complete array to convert to JSON output
array_insert($template, '', $resources);
array_insert($template, 'Resources', $outputs);
array_insert($template, 'Outputs', $header);

$output = json_encode($template, JSON_PRETTY_PRINT);
print $output;

// render HTML doc
$hl = new Highlight\Highlighter();
$r = $hl->highlight('json', $output);

$html = <<<HTML
<html>
    <head>
        <!-- Link to the stylesheets: -->
        <link rel="stylesheet" type="text/css" href="styles/obsidian.css">
    </head>
    <body>
        <!-- Print the highlighted code: -->
        <pre class="hljs <?=$r->language?>"><?=$r->value</pre>
</body>
</html>
HTML;

// write the HTML to a file for viewing
$file = fopen('template.html', 'w');
fwrite($file, $html);
fclose($file);

/**
 * getResources
 *
 * setup the resources section of the template
 *
 * @param null $options
 * @return array
 */
function getResources($options = null)
{
    $retVal = [
        'Resources' => [
            'InstanceSecurityGroup' => [
                'Properties' => [
                    'GroupDescription' => 'Enable SSH access via port 22',
                    'SecurityGroupIngress' => [
                        'CidrIp' => (isset($options['allow-ssh-from']) ? $options['allow-ssh-from'] : '0.0.0.0/0'),
                        'FromPort' => '22',
                        'IpProtocol' => 'tcp',
                        'ToPort' => '22'
                    ]
                ],
                'Type' => 'AWS::EC2::SecurityGroup'
            ]
        ]
    ];

    $numInstances = (isset($options['instances']) ? $options['instances'] : 1);

    $ec2Instances = [];
    for ($i = 1; $i <= $numInstances; $i++) {
        $ec2Template = [
            ($i > 1 ? "EC2Instance$i" : 'EC2Instance') => [
                'Properties' => [
                    'ImageId' => 'ami-b97a12ce',
                    'InstanceType' => (isset($options['instance-type']) ? $options['instance-type'] : 't2.small'),
                    'SecurityGroups' => [
                        'Ref' => 'InstanceSecurityGroup'
                    ]
                ],
                'Type' => 'AWS::EC2::Instance'
            ]
        ];
        $ec2Instances = array_merge($ec2Instances, $ec2Template);
    }
    // Add the EC2 instances to the resources section
    array_insert($retVal['Resources'], 'InstanceSecurityGroup', $ec2Instances);
    return $retVal;
}

/**
 * array_insert
 *
 * Insert an array inside another array
 *
 * @param $array
 * @param $position
 * @param $insert
 */
function array_insert(&$array, $position, $insert)
{

    $pos   = array_search($position, array_keys($array));
    $array = array_merge(
        array_slice($array, 0, $pos),
        $insert,
        array_slice($array, $pos)
    );
}
