<?php
	$keywords = array(
		"0" => array("hello", "good evening", "good morning", "hi", "good afternoon", "hey", "Hi there!"),
		"1" => array("thank you", "thankyou", "thanks", "thank", "You're welcome."),
		"2" => array("bye", "goodnight", "good night", "gn", "See ya!"),
		"3" => array("cost", "money", "price", "how much", "free", "The RICH program is free for students if it's supported by schools."),
		"4" => array("apply", "enroll", "sign up", "signup", "join", "Contact your school counselor to sign up for RICH."),
		"5" => array("google", "googleclassroom", "google classroom", "RICH Portal", "Portal", "The RICH Portal and Google Clasroom are online platforms available only to students"),
		"6" => array("principles", "four principles", "4 principles", "They are skills and ideas to help students become successful in school. The principles are: I matter. I am responsible. I am Considerate. I am using thinking strategies for school success."),
		"7" => array("overview", "mission", "innovation", "purpose", "Reach Into Cultural Heights (RICH) focuses on creating innovation for urban students using classroom and online self-directed learning strategies. RICH achieves its mission by using oral and written communication skills."),
		"8" => array("location", "located", "place", "We are located at Queens College."),
		"9" => array("in charge", "runs", "organizes", "Jacqueline O. Dawson, Ph.D. from Walden University in Education is the lead visionary for the transformation of the innovative concepts using the digital learning environment. Changing the attitude of the urban student is a collaborative effort that began with concern mothers who came together to build a protective environment and safety nest for theirs and community children. What began as the brainchild of a former NYC School Principal, Ms. Denize Brewer, a graduate of the Columbia University School of Education with a Masters in Education, today is being positioned to become a model strategy to guide youth to changing their attitudes for school and life success."),
		"10" => array("donate", "donation", "donations", "donating", "If you scroll down to the bottom on the home page you will see a donate button. Thank you for your support!"),
		"11" => array("what does rich stand for", "stand for", "RICH stands for Reach Into Cultural Heights."),
		"12" => array("how long", "existence", "founded", "created", "RICH was founded in 1998. It has been running for over 2 decades."),
		"13" => array("how many students", "student number", "students joined", "More than 1500."),
		"14"=> array("program", "does rich have a program", "what is rich's program", "what program does rich have", "implemented", "what does rich do", "rich do", "RICH uses the Reach For Success Program Model. Students will learn to master the RICH program guiding principles in small groups for a period of 7 to 9 weeks. Students will be introduced to web based projects that support the themes of developing self awareness and respecting cultural differences."),
		"15"=> array("who should use rich", "who is rich looking for", "use rich", "join rich", "Children that need to learn positive communication skills for school success. Students that have trouble maintaining confidence in the competitive school environment will learn a lot with RICH."),
		"16"=> array("results", "conclusion", "benefits", "Students will experience a raise in GPA. They will also show improvement in personal and social skills such as having more self-respect."),
		"17" => array("employees", "work", "work oppurtunities","RICH in the post-pandemic era is repositioning its business model approach. RICH a nonprofit 501 (c) (3) provides employment subcontracting services and in partnership with the NYC Department of Education and CUNY City University of New York. Remote internships are offered under the partnerships to CUNY college students and DOE high school students.")

	);

	$userString = $_POST['userString'];
	$answers = array();

	$tokensArray = tokenize($userString);
	$answers = matchKeywords($answers, $tokensArray, $keywords);

	echo json_encode($answers);

	function matchKeywords($answers, $tokensArray, $keywords){

		for ($i = 0; $i < sizeof($tokensArray); $i++){
			$ans = array();
			$ans = contains($tokensArray, $keywords, $tokensArray[$i], $tokensArray[$i + 1]);

			foreach ($ans as $j){
				array_push($answers, $j);
			}
		}
		return $answers;
	}

	function contains($tokensArray, $keywords, $i, $j){
		$answers = array();
		$phrase = $i . ' ' . $j;

		for ($x = 0; $x < sizeof($keywords); $x++){
			for($y = 0; $y < sizeof($keywords[$x]) - 1; $y++){
				if (($keywords[$x][$y] == $i) or ($keywords[$x][$y] == $phrase)){
					array_push($answers, $keywords[$x][sizeof($keywords[$x]) - 1]);
				}
			}
		}
		return $answers;
	}

	function tokenize($string){
		$tokensArray = explode(" ", $string);
		for($i = 0; $i < sizeof($tokensArray); $i++){
			$tokensArray[$i] = strtolower($tokensArray[$i]);
			$tokensArray[$i] = clean($tokensArray[$i]);
		}
		return $tokensArray;
	}

	function clean($string) {
   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special characters.
	}

?>
