<?php
include_once(__DIR__ . '/vendor/autoload.php');

use Symfony\Component\Yaml\Yaml;

$data = [];

$data['states'] = getStates();
$data['countries'] = getCountryCodes();
$data['providences'] = getProvidences(true);

$isCreatedStateCountryJSON = saveFile($data, 'statesProvidenceCountries', 'JSON');
$isStatesJSON = saveFile($data['states'], 'states', 'JSON');
$isCreatedCountryJSON = saveFile($data['countries'], 'countries', 'JSON');
$isStatesJSON = saveFile($data['providences'], 'providences');
$isCreatedStateCountryYml = saveFile($data, 'statesProvidenceCountries');
$isProvidenceYML = saveFile($data['providences'], 'providence', 'YAML');
$isStatesJSON = saveFile($data['states'], 'states');
$data['board'] = getBoardPositions();
$isBoardMembers = saveFile($data['board'], 'boardmembers', 'JSON');

$zip = getZipCodes();
$isCreatedZips = saveFile($zip, 'zipcodes', 'JSON');
$isCreatedZipsYml = saveFile($zip, 'zipcodes');

function saveFile (string|array $data, string $fileName, string $type = 'YAML'): bool 
{
    if ($type === 'JSON' && is_string($data) === true) {
        $return = file_put_contents($fileName .'.json', $data); 
    }
    if ($type === 'JSON' && is_array($data) === true) {
        $return = file_put_contents($fileName.'.json', json_encode($data));
    }
    if ($type === 'YAML' && is_array($data) === true) {
        $return =
        file_put_contents($fileName . '.yaml', Yaml::dump($data));
    }

    return $return ?? false;

}


function getStates (): array
{
    $states = [];
    $csv = explode("\n", trim(str_replace('"', '', file_get_contents('https://raw.githubusercontent.com/BlueEarOtter/List-of-US-States/patch-1/states.csv', 'r'))));
    if (is_array($csv)) {
        array_shift($csv);
        foreach ($csv as $state) {
            list($name, $abr) = explode(',', $state);
            $states['states'][$abr] = $name;
        }
    }

    return $states;

}

function getZipCodes() : array 
{
    $zips = [];
    $zipCsv = file_get_contents('https://raw.githubusercontent.com/scpike/us-state-county-zip/master/geo-data.csv');
    
    $zips = (array_map('str_getcsv', explode("\n", $zipCsv)));
    array_shift($zips);
    foreach ($zips as $key => $row) {
        $values = array_values($row);
        if (is_array($row) && count($values) > 4) {
            list($id, $state, $abr, $zipcode, $county, $city) = array_values($row);
            $zips[$id] = [$state, $abr, $zipcode, $county, $city];
        }
    }

    return $zips;
}

function getProvidences(bool $writeJson = true) : array {
    $providences = [];
    $json = getProvidenceJson();
    if ($writeJson === true) {
        saveFile($json, 'providences', 'JSON');
    }
    $providences = json_decode($json, true);

    return $providences;
}

function getProvidenceJson() : string 
{
    $pJson = file_get_contents('https://gist.githubusercontent.com/pbojinov/a87adf559d2f7e81d86ae67e7bd883c7/raw/f34362c96cce2e40b1cab4e330f4affb6c12d37e/canada_states_titlecase.json');
    return json_validate($pJson) ? $pJson : json_encode([]);
}

function getCountryCodes()
{
    return
    [
        'AF' => 'Afghanistan',
        'AL' => 'Albania',
        'DZ' => 'Algeria',
        'AS' => 'American Samoa',
        'AD' => 'Andorra',
        'AO' => 'Angola',
        'AI' => 'Anguilla',
        'AQ' => 'Antarctica',
        'AG' => 'Antigua And Barbuda',
        'AR' => 'Argentina',
        'AM' => 'Armenia',
        'AW' => 'Aruba',
        'AU' => 'Australia',
        'AT' => 'Austria',
        'AZ' => 'Azerbaijan',
        'BS' => 'Bahamas',
        'BH' => 'Bahrain',
        'BD' => 'Bangladesh',
        'BB' => 'Barbados',
        'BY' => 'Belarus',
        'BE' => 'Belgium',
        'BZ' => 'Belize',
        'BJ' => 'Benin',
        'BM' => 'Bermuda',
        'BT' => 'Bhutan',
        'BO' => 'Bolivia',
        'BA' => 'Bosnia And Herzegovina',
        'BW' => 'Botswana',
        'BV' => 'Bouvet Island',
        'BR' => 'Brazil',
        'IO' => 'British Indian Ocean Territory',
        'BN' => 'Brunei Darussalam',
        'BG' => 'Bulgaria',
        'BF' => 'Burkina Faso',
        'BI' => 'Burundi',
        'KH' => 'Cambodia',
        'CM' => 'Cameroon',
        'CA' => 'Canada',
        'CV' => 'Cape Verde',
        'KY' => 'Cayman Islands',
        'CF' => 'Central African Republic',
        'TD' => 'Chad',
        'CL' => 'Chile',
        'CN' => 'China',
        'CX' => 'Christmas Island',
        'CC' => 'Cocos (keeling) Islands',
        'CO' => 'Colombia',
        'KM' => 'Comoros',
        'CG' => 'Congo',
        'CD' => 'Congo, The Democratic Republic Of The',
        'CK' => 'Cook Islands',
        'CR' => 'Costa Rica',
        'CI' => 'Cote D\'ivoire',
        'HR' => 'Croatia',
        'CU' => 'Cuba',
        'CY' => 'Cyprus',
        'CZ' => 'Czech Republic',
        'DK' => 'Denmark',
        'DJ' => 'Djibouti',
        'DM' => 'Dominica',
        'DO' => 'Dominican Republic',
        'TP' => 'East Timor',
        'EC' => 'Ecuador',
        'EG' => 'Egypt',
        'SV' => 'El Salvador',
        'GQ' => 'Equatorial Guinea',
        'ER' => 'Eritrea',
        'EE' => 'Estonia',
        'ET' => 'Ethiopia',
        'FK' => 'Falkland Islands (malvinas)',
        'FO' => 'Faroe Islands',
        'FJ' => 'Fiji',
        'FI' => 'Finland',
        'FR' => 'France',
        'GF' => 'French Guiana',
        'PF' => 'French Polynesia',
        'TF' => 'French Southern Territories',
        'GA' => 'Gabon',
        'GM' => 'Gambia',
        'GE' => 'Georgia',
        'DE' => 'Germany',
        'GH' => 'Ghana',
        'GI' => 'Gibraltar',
        'GR' => 'Greece',
        'GL' => 'Greenland',
        'GD' => 'Grenada',
        'GP' => 'Guadeloupe',
        'GU' => 'Guam',
        'GT' => 'Guatemala',
        'GN' => 'Guinea',
        'GW' => 'Guinea-bissau',
        'GY' => 'Guyana',
        'HT' => 'Haiti',
        'HM' => 'Heard Island And Mcdonald Islands',
        'VA' => 'Holy See (vatican City State)',
        'HN' => 'Honduras',
        'HK' => 'Hong Kong',
        'HU' => 'Hungary',
        'IS' => 'Iceland',
        'IN' => 'India',
        'ID' => 'Indonesia',
        'IR' => 'Iran, Islamic Republic Of',
        'IQ' => 'Iraq',
        'IE' => 'Ireland',
        'IL' => 'Israel',
        'IT' => 'Italy',
        'JM' => 'Jamaica',
        'JP' => 'Japan',
        'JO' => 'Jordan',
        'KZ' => 'Kazakstan',
        'KE' => 'Kenya',
        'KI' => 'Kiribati',
        'KP' => 'Korea, Democratic People\'s Republic Of',
        'KR' => 'Korea, Republic Of',
        'KV' => 'Kosovo',
        'KW' => 'Kuwait',
        'KG' => 'Kyrgyzstan',
        'LA' => 'Lao People\'s Democratic Republic',
        'LV' => 'Latvia',
        'LB' => 'Lebanon',
        'LS' => 'Lesotho',
        'LR' => 'Liberia',
        'LY' => 'Libyan Arab Jamahiriya',
        'LI' => 'Liechtenstein',
        'LT' => 'Lithuania',
        'LU' => 'Luxembourg',
        'MO' => 'Macau',
        'MK' => 'Macedonia, The Former Yugoslav Republic Of',
        'MG' => 'Madagascar',
        'MW' => 'Malawi',
        'MY' => 'Malaysia',
        'MV' => 'Maldives',
        'ML' => 'Mali',
        'MT' => 'Malta',
        'MH' => 'Marshall Islands',
        'MQ' => 'Martinique',
        'MR' => 'Mauritania',
        'MU' => 'Mauritius',
        'YT' => 'Mayotte',
        'MX' => 'Mexico',
        'FM' => 'Micronesia, Federated States Of',
        'MD' => 'Moldova, Republic Of',
        'MC' => 'Monaco',
        'MN' => 'Mongolia',
        'MS' => 'Montserrat',
        'ME' => 'Montenegro',
        'MA' => 'Morocco',
        'MZ' => 'Mozambique',
        'MM' => 'Myanmar',
        'NA' => 'Namibia',
        'NR' => 'Nauru',
        'NP' => 'Nepal',
        'NL' => 'Netherlands',
        'AN' => 'Netherlands Antilles',
        'NC' => 'New Caledonia',
        'NZ' => 'New Zealand',
        'NI' => 'Nicaragua',
        'NE' => 'Niger',
        'NG' => 'Nigeria',
        'NU' => 'Niue',
        'NF' => 'Norfolk Island',
        'MP' => 'Northern Mariana Islands',
        'NO' => 'Norway',
        'OM' => 'Oman',
        'PK' => 'Pakistan',
        'PW' => 'Palau',
        'PS' => 'Palestinian Territory, Occupied',
        'PA' => 'Panama',
        'PG' => 'Papua New Guinea',
        'PY' => 'Paraguay',
        'PE' => 'Peru',
        'PH' => 'Philippines',
        'PN' => 'Pitcairn',
        'PL' => 'Poland',
        'PT' => 'Portugal',
        'PR' => 'Puerto Rico',
        'QA' => 'Qatar',
        'RE' => 'Reunion',
        'RO' => 'Romania',
        'RU' => 'Russian Federation',
        'RW' => 'Rwanda',
        'SH' => 'Saint Helena',
        'KN' => 'Saint Kitts And Nevis',
        'LC' => 'Saint Lucia',
        'PM' => 'Saint Pierre And Miquelon',
        'VC' => 'Saint Vincent And The Grenadines',
        'WS' => 'Samoa',
        'SM' => 'San Marino',
        'ST' => 'Sao Tome And Principe',
        'SA' => 'Saudi Arabia',
        'SN' => 'Senegal',
        'RS' => 'Serbia',
        'SC' => 'Seychelles',
        'SL' => 'Sierra Leone',
        'SG' => 'Singapore',
        'SK' => 'Slovakia',
        'SI' => 'Slovenia',
        'SB' => 'Solomon Islands',
        'SO' => 'Somalia',
        'ZA' => 'South Africa',
        'GS' => 'South Georgia And The South Sandwich Islands',
        'ES' => 'Spain',
        'LK' => 'Sri Lanka',
        'SD' => 'Sudan',
        'SR' => 'Suriname',
        'SJ' => 'Svalbard And Jan Mayen',
        'SZ' => 'Swaziland',
        'SE' => 'Sweden',
        'CH' => 'Switzerland',
        'SY' => 'Syrian Arab Republic',
        'TW' => 'Taiwan, Province Of China',
        'TJ' => 'Tajikistan',
        'TZ' => 'Tanzania, United Republic Of',
        'TH' => 'Thailand',
        'TG' => 'Togo',
        'TK' => 'Tokelau',
        'TO' => 'Tonga',
        'TT' => 'Trinidad And Tobago',
        'TN' => 'Tunisia',
        'TR' => 'Turkey',
        'TM' => 'Turkmenistan',
        'TC' => 'Turks And Caicos Islands',
        'TV' => 'Tuvalu',
        'UG' => 'Uganda',
        'UA' => 'Ukraine',
        'AE' => 'United Arab Emirates',
        'GB' => 'United Kingdom',
        'US' => 'United States',
        'UM' => 'United States Minor Outlying Islands',
        'UY' => 'Uruguay',
        'UZ' => 'Uzbekistan',
        'VU' => 'Vanuatu',
        'VE' => 'Venezuela',
        'VN' => 'Vietnam',
        'VG' => 'Virgin Islands, British',
        'VI' => 'Virgin Islands, U.s.',
        'WF' => 'Wallis And Futuna',
        'EH' => 'Western Sahara',
        'YE' => 'Yemen',
        'ZM' => 'Zambia',
        'ZW' => 'Zimbabwe',
    ];
    
}

function getBoardPositions() : array 
{
    return
    $boardsPositiions = [
        [
            'title' => 'Board of Directors',
            'description' => 'A board of directors is the group of people responsible for 
        the strategic management of a for-profit or nonprofit corporation. Depending on 
        the size of the board, the members might run the business activities of the 
        organization or oversee office staff that handle the day-to-day duties. The board 
        operates by following the corporation\’s bylaws, a set of rules that governs how the 
        organization must pursue its mission and activities.'
        ],
        [
            'title' => 'President/Chairman of the Board',
            'description' => 'The top position of a board is the chairman, chairperson or sometimes 
        simply chair, who often serves as the president of the organization. In his chairman\'s role, 
        the board member runs board meetings, appoints committees and performs other duties as directed 
        by the bylaws. As president, this individual represents the organization in public by 
        giving speeches, writing articles and attending functions on behalf of the organization.'
        ],
        [
            'title' => 'Vice President/Vice Chair',
            'description' => 'Serving directly under the chair is the vice chair or vice president. This 
        person is often next in line to become the chair and serves as the board\’s leader when the chair 
        is not present, such as during official board meetings. Some organizations have multiple vice 
        presidents comprising an executive committee. In that case, this position is known as the first 
        vice president.'
        ],
        [
            'title' => 'Secretary',
            'description' => 'The secretary of a board takes notes, called minutes, at board meetings, then submits those minutes 
        for amendment or approval by the board. If the organization does not have a business office, the 
        secretary keeps its records and its non-financial legal documents, including its bylaws, articles 
        of incorporation and minutes of historical meetings.'
        ],
        [
            'title' => 'Treasurer',
            'description' => 'The treasurer of a board keeps the organization\’s financial records, unless 
        the organization has a professional accountant or business manager. In that case, the treasurer 
        keeps copies of the main financial records, signs checks the business manager or accountant 
        writes, approves purchases and invoices and otherwise oversees and keeps an eye on the 
        organization\’s finances. The treasurer also prepares and delivers a treasurer\’s report at 
        each of the board\’s official meetings and approves the organization\’s annual tax filing. Many 
        smaller organizations combine the secretary and treasurer positions, giving this position the 
        title of secretary/treasurer.'
        ],
        [
            'title' => 'Board Members',
            'description' => 'Board members who do not have one of the previously discussed roles often 
        volunteer to head committees such as a marketing or website committee. These board members 
        attend meetings, receive updates and vote on board matters. They have the right to make motions, 
        discuss them and vote on them. These positions come with a chairperson title, such as a marketing 
        committee chair. After serving as a board member, these individuals might ascend to the secretary, 
        treasurer, vice chair and eventually chairman of the board positions. Some board members represent 
        specific geographic areas, often when the organization is a nonprofit with members. For example, a 
        board might have northern, southern, eastern and western districts, with a board member required 
        to reside within the boundaries of her district.'
        ],

    ];
    
}