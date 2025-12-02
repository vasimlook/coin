<?php

function formatDecimal($value)
{
    // Convert the decimal value to a formatted string
    $formattedValue = number_format($value, 2, '.', '');

    // Remove trailing zeros and the decimal point if the value is an integer
    $formattedValue = rtrim($formattedValue, '0');
    $formattedValue = rtrim($formattedValue, '.');

    return $formattedValue;
}

function formatToTwoDecimalPlaces($number) {
    // Format the number with exactly two digits after the decimal point
    $formattedNumber = number_format($number, 2, '.', '');
    return $formattedNumber;
}

function pr($data, $die = 0)
{
    if ($die == 0) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    } else {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        die;
    }
}

function check_valid_price($price)
{
    if (preg_match('/^\d+(\.\d{0,2})?$/', $price)) {
        return true;
    } else {
        return false;
    }
}

if (!function_exists('successOrErrorMessage')) {
    function successOrErrorMessage($message, $type)
    {
        $_SESSION[$type] = 1;
        $_SESSION['message'] = $message;
    }
}

function set_selected($desired_value, $new_value)
{
    if ($desired_value === $new_value) {
        $str = 'selected="selected" ';
        return $str;
    } else {
        return '';
    }
}

function set_cheked($desired_value, $new_value)
{
    if ($desired_value === $new_value) {
        $str = ' checked ';
        return $str;
    } else {
        return '';
    }
}

function sessionAdmin($row)
{
    $session_data = array();
    foreach ($row as $key => $value) {
        $session_data['admin'][$key] = $value;
    }   
    return $session_data;
}
function sessionCheckAdmin()
{
    if ((!isset($_SESSION['admin']['id']))) {
        delete_cookie('_xlozgqian');
        header('Location: ' . ADMIN_LOGOUT_LINK);
        exit();
    }
    return true;
}

function sessionUser($row)
{
    $session_data = array();
    foreach ($row as $key => $value) {
        $session_data['user'][$key] = $value;
    }   
    return $session_data;
}
function sessionCheckUser()
{
    if ((!isset($_SESSION['user']['id']))) {
        delete_cookie('_xlozgqian');
        header('Location: ' . USER_LOGOUT_LINK);
        exit();
    }
    return true;
}

function logout_wrong_url()
{
    delete_cookie('_xlozgqian');
    delete_cookie('_devicedata');
    header('Location: ' . USER_LOGOUT_LINK);
    exit();
}

function encrypt_decrypt_custom($string, $action = 'encrypt')
{
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'AA74CDCC2BBRT935136HH7B63C27'; // user define private key
    $secret_iv = 'j&j=loveelse7UBB'; // user define secret key
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16); // sha256 is hash_hmac_algo
    if ($action == 'encrypt') {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if ($action == 'decrypt') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

function check_html_injection_new($data = [])
{
    $regex = "/(<.*?script.*?>)/";
    $regex2 = "/(&lt.*?script.*?&gt)/";
    $regex_html_tag = "/<(?:\"[^\"]*\"['\"]*|'[^']*'['\"]*|[^'\">])+>/";
    if (!empty($data)) {
        foreach ($data as $key => $value) {
            if (gettype($value) == 'array') {
                if (!check_html_injection_new($value)) {
                    return false;
                }
            } else {
                if (preg_match($regex_html_tag, $value)) {
                    return false;
                }
                if (preg_match($regex, $value)) {
                    return false;
                }
                if (preg_match($regex2, $value)) {
                    return false;
                }
            }
        }
    }
    return true;
}

function deleteOldLogFiles($directory)
{
    $files = glob(rtrim($directory, '/') . '/*');

    if ($files === false) {
        return;
    }

    foreach ($files as $file) {
        if (is_file($file) && filemtime($file) < strtotime('-2 days')) {
            unlink($file);
        } elseif (is_dir($file)) {
            deleteOldLogFiles($file); // Recursively delete files in subdirectories
        }
    }
}

function final_url_dpboss($urls)
{
    foreach ($urls as $row) {

        $finalUrl = $row['name'];
        if (filter_var(gethostbyname($row['name']), FILTER_VALIDATE_IP) == false) {
        } else {
            $ch = curl_init($row['name']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            $response = curl_exec($ch);
            $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
            curl_close($ch);
        }

        $ch = curl_init($finalUrl);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode == 200) {
            return $row['name'];
        }
    }
    return false;
}

function send_otp($mobileNumber, $otp)
{
    $authKey = SMS_API_KEY;
    $senderId = "PINJAR";
    $message = $otp . urlencode(" is your OTP For phone verification. Do not share this with anyone. PINJAR");
    $route = 4;
    $postData = array(
        'authkey' => $authKey,
        'mobiles' => $mobileNumber,
        'message' => $message,
        'sender' => $senderId,
        'route' => $route
    );
    $url = "http://sms.smslab.in/api/sendhttp.php?authkey=$authKey&mobiles=$mobileNumber&message=$message&sender=$senderId&route=4&DLT_TE_ID=1307170236037209632";
    $ch = curl_init();

    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Cookie: PHPSESSID=6u3hq8lu2f6qagscnm7oonr4q7'
        ),
    ));
    $output = curl_exec($ch);
    curl_close($ch);
    return true;
}

function send_otp_fast2($mobileNumber, $otp)
{
    $authKey = FAST2_SMS_API_KEY;
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2?authorization=$authKey&variables_values=$otp&route=otp&numbers=" . urlencode("$mobileNumber"),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache"
        ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    return true;
}

function load_view($folder, $page, $data = array())
{
    if (!is_file(APPPATH . "/Views/$page" . '.php')) {
        // Whoops, we don't have a page for that!
        throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
    }
    echo view($folder . '/common/header', $data);
    echo view($folder . '/common/sidebar', $data);
    echo view($folder . '/common/topnavigation', $data);
    echo view($page, $data);
    echo view($folder . '/common/footer', $data);
}

function single_page($page, $data = array())
{
    if (!is_file(APPPATH . "/Views/$page" . '.php')) {
        // Whoops, we don't have a page for that!
        throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
    }
    echo view($page, $data);
}

function removeTrailingZeros($number)
{
    // Convert the number to a string to manipulate it
    $numberAsString = (string) $number;

    // Remove trailing zeros after the decimal point
    $numberAsString = rtrim($numberAsString, '0');

    // Remove the decimal point if there are no remaining digits after it
    $numberAsString = rtrim($numberAsString, '.');

    return $numberAsString;
}

// function split_string_by_soace_or_position($string = '', $chunk_size = 0)
// {
//     $words = explode(" ", $string); // Split the string into an array of words

//     $chunks = [];
//     $current_chunk = '';

//     foreach ($words as $word) {
//         // Check if adding the word to the current chunk would exceed the chunk size
//         if (strlen($current_chunk . ' ' . $word) > $chunk_size) {
//             // If yes, add the current chunk to the list of chunks
//             $chunks[] = $current_chunk;
//             // Start a new chunk with the current word
//             $current_chunk = $word;
//         } else {
//             // If not, append the word to the current chunk
//             if ($current_chunk != '') {
//                 $current_chunk .= ' ';
//             }
//             $current_chunk .= $word;
//         }
//     }

//     // Add the last chunk
//     $chunks[] = $current_chunk;

//     // Split chunks exceeding 10 characters into smaller chunks
//     $final_chunks = [];
//     foreach ($chunks as $chunk) {
//         $chunk_length = strlen($chunk);
//         if ($chunk_length > $chunk_size) {
//             $num_sub_chunks = ceil($chunk_length / $chunk_size);
//             $sub_chunks = str_split($chunk, $chunk_size);
//             $final_chunks = array_merge($final_chunks, $sub_chunks);
//         } else {
//             $final_chunks[] = $chunk;
//         }
//     }

//     return implode("<br>", $final_chunks);
// }

/**
 * Split a string into chunks by spaces up to $chunk_size characters.
 * Safely handles Hindi/Unicode. Falls back to mb_* if grapheme_* not available.
 */
function split_string_by_space_or_position(string $string = '', int $chunk_size = 10, string $encoding = 'UTF-8'): string
{
    if ($chunk_size <= 0 || $string === '') {
        return trim($string);
    }

    // Choose safe length/substr functions (grapheme-aware preferred)
    $useGrapheme = function_exists('grapheme_strlen') && function_exists('grapheme_substr');

    $strlen = function (string $s) use ($useGrapheme, $encoding): int {
        return $useGrapheme ? grapheme_strlen($s) : mb_strlen($s, $encoding);
    };

    $substr = function (string $s, int $start, ?int $len = null) use ($useGrapheme, $encoding): string {
        if ($useGrapheme) {
            return grapheme_substr($s, $start, $len);
        }
        if ($len === null) {
            return mb_substr($s, $start, null, $encoding);
        }
        return mb_substr($s, $start, $len, $encoding);
    };

    // Normalize whitespace and split on Unicode spaces
    $string = preg_replace('/\s+/u', ' ', trim($string));
    $words  = preg_split('/\s+/u', $string, -1, PREG_SPLIT_NO_EMPTY);

    $chunks = [];
    $current = '';

    foreach ($words as $word) {
        $candidate = ($current === '') ? $word : ($current . ' ' . $word);

        if ($strlen($candidate) <= $chunk_size) {
            // Safe to add this word to the current line
            $current = $candidate;
        } else {
            // Push the current line if it has content
            if ($current !== '') {
                $chunks[] = $current;
            }

            // If a single word is longer than chunk size, split it safely
            while ($strlen($word) > $chunk_size) {
                $chunks[] = $substr($word, 0, $chunk_size);
                $word = $substr($word, $chunk_size);
            }

            // Start a new line with the remaining part of the word (may be empty)
            $current = $word;
        }
    }

    if ($current !== '') {
        $chunks[] = $current;
    }

    return implode('<br>', $chunks);
}


function sortArrayByValue($a, $b) {
    return $a['id'] - $b['id'];
}

function sortArrayByValueIndex($a, $b) {
    return $a[1] - $b[1];
}

function build_farti_jodi_html($farti_jodies = array())
    {
        $html = '<thead>
                    <tr>
                        <th>Name</th>
                        <th>Points</th>                       
                    </tr>
                </thead>';

        $dataRow = '';

        if (is_array($farti_jodies) && sizeof($farti_jodies) > 0) {
            foreach ($farti_jodies as $key => $admin) {
                $games = $admin->game;
                $amount = $admin->total_price;

                $dataRow .= ' <tr>
                                <td>' . $games . '</td>                               
                                <td>' . $amount . '</td>
                            </tr>';
            }
        }
        else
        {
            $dataRow .= ' <tr><td valign="top" colspan="2" style="text-align: center;background-color: #f5f6fa;border-bottom: 1px solid #b2b2b2;">No matching records found</td></tr>';
        }

        $adminList = '<table class="table">
                        '.$html.$dataRow.'
                      </table>';                         
        return $adminList;
    }
    function random_name($limit = 100)
    {
        // Array of common Indian first names
        $indianFirstNames = [
            "Aarav", "Aadhya", "Advik", "Ananya", "Arnav", "Aryan", "Ishaan", "Kabir", "Krishna", "Mohammed",
            "Neha", "Nikhil", "Priya", "Rahul", "Riya", "Saanvi", "Siddharth", "Tanvi", "Tara", "Yash",
            "Abhinav", "Aditi", "Aishwarya", "Amit", "Anita", "Arya", "Ashish", "Deepika", "Dev", "Dinesh",
            "Divya", "Gaurav", "Gopal", "Ishita", "Jaya", "Karan", "Kavita", "Manish", "Meera", "Nandini",
            "Nisha", "Pooja", "Raj", "Rohit", "Sanjay", "Shalini", "Shiv", "Sunil", "Uma", "Varun",
            "Vijay", "Vinay", "Yogesh", "Zoya", "Vishal", "Anjali", "Hitesh", "Arun", "Rajesh", "Rishi",
            "Shreya", "Harish", "Akash", "Suresh", "Kiran", "Maya", "Arjun", "Hema", "Ravi", "Renuka",
            "Rani", "Vivek", "Preeti", "Rajiv", "Kavita", "Ritu", "Mohan", "Shobha", "Rahul", "Anushka",
            "Anand", "Lalita", "Ramesh", "Sonia", "Satish", "Rajendra", "Mukesh", "Sarita", "Parul", "Alok",
            "Lata", "Mahesh", "Rajni", "Prakash", "Jyoti", "Vikas", "Meenakshi", "Naveen", "Seema", "Rani",
            "Sanjeev", "Swati", "Deepak", "Sangeeta", "Asha", "Vikram", "Ritu", "Raghav", "Sunita", "Ravi",
            "Nidhi", "Rohini", "Amita", "Anil", "Priti", "Arvind", "Usha", "Vinod", "Shobha", "Rakesh",
            "Sunita", "Nitin", "Geeta", "Madhu", "Sarla", "Sham", "Pramod", "Shalini", "Anjana", "Pawan",
            "Jaya", "Hari", "Anita", "Jatin", "Shobhana", "Sarvesh", "Kirti", "Sudha", "Santosh", "Kusum",
            "Ranjeet", "Nalini", "Rakesh", "Manju", "Girish", "Rajani", "Rajeev", "Shubham", "Leela", "Subhash",
            "Anil", "Meena", "Naresh", "Nita", "Rajeev", "Ranjana", "Raghunath", "Komal", "Pramila", "Brijesh",
            "Vandana", "Raman", "Savita", "Prem", "Sadhana", "Bhushan", "Indira", "Rajnish", "Kanta", "Puneet",
            "Neelam", "Rajkumar", "Shilpa", "Raman", "Manisha", "Gopal", "Laxmi", "Nitin", "Saroj", "Rajesh",
            "Sadhana", "Praveen", "Anuradha", "Mahesh", "Sheela", "Rahul", "Kavita", "Ram", "Kumari", "Sushma",
            "Dinesh", "Kamlesh", "Narayan", "Rekha", "Narinder", "Amit", "Bimla", "Gulshan", "Surendra", "Rupa",
            "Raj", "Vandana", "Kiran", "Geeta", "Pradeep", "Sangeeta", "Vinay", "Rani", "Pawan", "Anjali",
            "Ravi", "Saroj", "Alok", "Kamla", "Pankaj", "Asha", "Gopal", "Kavita", "Vinod", "Reena",
            "Pradeep", "Kiran", "Manoj", "Shalini", "Anil", "Neetu", "Rajesh", "Sharda", "Rajendra", "Kusum",
            "Sanjeev", "Indu", "Arvind", "Seema", "Santosh", "Nirmala", "Anil", "Anita", "Sunil", "Shanti",
            "Rakesh", "Lalita", "Ravi", "Vidya", "Rajesh", "Gita", "Vijay", "Poonam", "Anand", "Renu",
            "Amit", "Rashmi", "Pradeep",
            "Patel", "Shah", "Kumar", "Singh", "Das", "Gupta", "Chauhan", "Jain", "Pandey", "Reddy",
            "Agarwal", "Bhatt", "Desai", "Mehta", "Sharma", "Verma", "Joshi", "Shah", "Malhotra", "Thakkar",
            "Trivedi", "Khanna", "Parekh", "Shroff", "Dave", "Patil", "Jha", "Sinha", "Saxena", "Varma",
            "Goswami", "Kulkarni", "Tiwari", "Nair", "Menon", "Banerjee", "Chatterjee", "Sen", "Mukherjee", "Choudhury",
            "Ghosh", "Sarkar", "Dutta", "Dutta", "Basu", "Roy", "Dasgupta", "Bose", "Dey", "Majumdar",
            "Chowdhury", "Mitra", "Sengupta", "Ganguly", "Pal", "Mondal", "Saha", "Deb", "Sarkar", "Biswas",
            "Roy", "Kar", "Ghoshal", "Ghosh", "Sen", "Das", "Mazumdar", "Mukhopadhyay", "Mukherjee", "Nath",
            "Roy", "Chakraborty", "Paul", "Bhattacharya", "Gupta", "Dutta", "Bandyopadhyay", "Biswas", "Kundu", "Bose",
            "Dey", "Mandal", "Majumdar", "Ghosh", "Banerjee", "Roy", "Dutta", "Mukherjee", "Das", "Mitra",
            "Ghosh", "Mukhopadhyay", "Sarkar", "Dasgupta", "Bhattacharjee", "Bhattacharya", "Goswami", "Biswas", "Dutta", "Chakraborty",
            "Bhattacharya", "Majumdar", "Das", "Ganguly", "Das", "Roy", "Chatterjee", "Sen", "Datta", "Biswas",
            "Bhattacharya", "Ghosh", "Sarkar", "Ghosh", "Gupta", "Chowdhury", "Mitra", "Sengupta", "Ganguly", "Pal",
            "Mondal", "Saha", "Deb", "Sarkar", "Biswas", "Roy", "Kar", "Ghoshal", "Ghosh", "Sen",
            "Das", "Mazumdar", "Mukhopadhyay", "Mukherjee", "Nath", "Roy", "Chakraborty", "Paul", "Bhattacharya", "Gupta",
            "Dutta", "Bandyopadhyay", "Biswas", "Kundu", "Bose", "Dey", "Mandal", "Majumdar", "Ghosh", "Banerjee",
            "Roy", "Dutta", "Mukherjee", "Das", "Mitra", "Ghosh", "Mukhopadhyay", "Sarkar", "Dasgupta", "Bhattacharjee",
            "Bhattacharya", "Goswami", "Biswas", "Dutta", "Chakraborty", "Bhattacharya", "Majumdar", "Das", "Ganguly", "Das",
            "Roy", "Chatterjee", "Sen", "Datta", "Biswas", "Bhattacharya", "Ghosh", "Sarkar", "Ghosh", "Gupta",
            "Chowdhury", "Mitra", "Sengupta", "Ganguly", "Pal", "Mondal", "Saha", "Deb", "Sarkar", "Biswas",
            "Roy", "Kar", "Ghoshal", "Ghosh", "Sen", "Das", "Mazumdar", "Mukhopadhyay", "Mukherjee", "Nath",
            "Roy", "Chakraborty", "Paul", "Bhattacharya", "Gupta", "Dutta", "Bandyopadhyay", "Biswas", "Kundu", "Bose",
            "Dey", "Mandal", "Majumdar", "Ghosh", "Banerjee", "Roy", "Dutta", "Mukherjee", "Das", "Mitra",
            "Ghosh", "Mukhopadhyay", "Sarkar", "Dasgupta", "Bhattacharjee", "Bhattacharya", "Goswami", "Biswas", "Dutta", "Chakraborty",
            "Bhattacharya", "Majumdar", "Das", "Ganguly", "Das", "Roy", "Chatterjee", "Sen", "Datta", "Biswas",
            "Bhattacharya", "Ghosh", "Sarkar", "Ghosh", "Gupta", "Chowdhury", "Mitra", "Sengupta", "Ganguly", "Pal",
            "Mondal", "Saha", "Deb", "Sarkar", "Biswas", "Roy", "Kar", "Ghoshal", "Ghosh", "Sen",
            "Das", "Mazumdar", "Mukhopadhyay", "Mukherjee", "Nath", "Roy", "Chakraborty", "Paul", "Bhattacharya", "Gupta",
            "Dutta", "Bandyopadhyay", "Biswas", "Kundu", "Bose", "Dey", "Mandal", "Majumdar", "Ghosh", "Banerjee",
            "Roy", "Dutta", "Mukherjee", "Das", "Mitra", "Ghosh", "Mukhopadhyay", "Sarkar", "Dasgupta", "Bhattacharjee",
            "Bhattacharya", "Goswami", "Biswas", "Dutta", "Chakraborty", "Bhattacharya", "Majumdar", "Das", "Ganguly", "Das",
            "Roy", "Chatterjee", "Sen", "Datta", "Biswas", "Bhattacharya", "Ghosh", "Sarkar",
        ];
        
        // Function to generate a random Indian name   
        $randomNames = [];
        for ($i = 0; $i < $limit; $i++) {
            $randomNumber = rand(10, 1000);
            $randomNumber2 = rand(1001, 5000);                                  
            $randomNumber3 = rand(5001, 10000);
            $randomNumber4 = rand(10001, 20000);
    
            $values = [$randomNumber, $randomNumber2,$randomNumber3,$randomNumber4]; // Replace with your actual values
            $randomValue = $values[array_rand($values)];
            $dummy_arr = [];
            $dummy_arr['name'] = generateRandomIndianName($indianFirstNames);
            $dummy_arr['profile_img'] = rand(1, 40);       
            $dummy_arr['win_amount'] = $randomValue;
            $randomNames[] = $dummy_arr;
        }
        return $randomNames;    
    }

    function randomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charLength = strlen($characters);
        $random = '';

        for ($i = 0; $i < $length; $i++) {
            $random .= $characters[random_int(0, $charLength - 1)];
        }

        return $random;
    }

    
    function generateRandomIndianName($firstNames)
    {
        $randomFirstNameIndex = array_rand($firstNames);        
        $firstName = $firstNames[$randomFirstNameIndex];        
        return "$firstName";
    }

function create_log($admin_id,$type,$message,$log_type)
{
    $model = new \App\Models\Admin_m();
    $params = [
        'admin_id' => $admin_id,
        'type' => $type,
        'message' => $message,
        'log_type' => $log_type,
        'datetime' => date('Y-m-d H:i:s')
    ];
    $log = $model->insert_log($params);
}

function getWeekStartAndEnd($year, $week)
{
    $date = new DateTime();
    $date->setISODate($year, $week);
    $weekStart = $date->format('Y-m-d');
    $date->modify('+6 days');
    $weekEnd = $date->format('Y-m-d');
    
    return ['week_start' => $weekStart, 'week_end' => $weekEnd];
}

function add_result_delhi($market_id, $date = '', $aankdo_open = '', $figure_open = '', $figure_close = '')
{
    $model_Admin_m = new \App\Models\Admin_m();
    if (isset($date) && !empty($date)) {
        $last_aankdo = [];
        $res = false;
        $aankdo = [];
        $aankdo = $model_Admin_m->get_delhi_aankdo(date("Y-m-d", strtotime($date)), $market_id);
        
        if(empty($aankdo)){
            $last_aankdo = $model_Admin_m->get_last_delhi_aankdo($market_id,date("Y-m-d", strtotime($date)));
        }
        if(!empty($last_aankdo) && $last_aankdo['jodi'] == $aankdo_open && !isset($_POST['added_by_admin'])){
            return array("status" => 0);
        }
        
        $date = date("Y-m-d", strtotime($date));
        $params = array();
        if($figure_open != '' && $figure_close != ''){
            $params['aankdo_date'] = $date;
            $params['refMarket_id'] = $market_id;
            $params['figure_open'] = $figure_open;
            $params['figure_close'] = $figure_close;
            $params['jodi'] = $figure_open.$figure_close;
        }
        if (!empty($aankdo) && !empty($params)) {
            if (isset($_POST['added_by_admin']) && $aankdo_open != $aankdo['jodi']) {
                $res = $model_Admin_m->add_delhi_aankdo($params, $aankdo['aankdo_id']);
            }
        } else {
            if(!empty($params)){
                $res = $model_Admin_m->add_delhi_aankdo($params);
            }
        }
        if ($res) {
            return array("status" => 1);
        } else {
            return array("status" => 0);
        }
    }
    return array("status" => 0);
}

function convertToHindi($string = '')
{
    return $string;
}
function isWebView() {
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
    return (strpos($ua, 'wv') !== false) || 
        (preg_match('/iPhone|iPod|iPad/i', $ua) && strpos($ua, 'Safari') === false);
}

function sendPushNotification($title, $message) {
    // sendPushNotification('This is test','123-66-123');
    if(!empty(ONSIGNAL_APP_ID)){
        $appId = ONSIGNAL_APP_ID;
        $restKey = ONSIGNAL_APP_SECRET;

        $content = array(
            "en" => $message
        );

        $headings = array(
            "en" => $title
        );

        $fields = array(
            'app_id' => $appId,
            'included_segments' => array('All'),
            'contents' => $content,
            'headings' => $headings
        );

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic ' . $restKey
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
    return true;
}


