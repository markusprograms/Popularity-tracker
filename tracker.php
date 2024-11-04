<?php 
    # Set your Github username
    $githubUsername = "markusprograms"; 
?>

<!DOCTYPE html>

<?php
    $githubUrl = "https://api.github.com/users/$githubUsername"; 

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $githubUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0");
    $githubRaw = curl_exec($ch);
    curl_close($ch);

    $githubParsed = json_decode($githubRaw); 
    $githubFollowers = $githubParsed->followers; 

    $githubLikes = 0; 
    $i = 1; 
    while (true) {
        $githubUrl = "https://api.github.com/users/$githubUsername/repos?page=$i"; 

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $githubUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0");
        $githubRaw = curl_exec($ch);
        curl_close($ch);

        $githubParsed = json_decode($githubRaw); 

        for ($j = 0; $j < count($githubParsed); $j ++) {
            $githubLikes += $githubParsed[$j]->stargazers_count; 
        }

        if (count($githubParsed) != 30) {
            break; 
        }

        $i ++; 
    }

    echo "Github followers: $githubFollowers<br>"; 
    echo "Github likes: $githubLikes"; 
?>
