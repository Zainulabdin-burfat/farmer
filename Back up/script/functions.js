/* Dashboard*/
	function _dashboard(){
		var aj;
		if (window.XMLHttpRequest) {
			aj = new XMLHttpRequest();
		}else{
			aj = new ActiveXObject("Microsoft.XMLHTTP");
		}

		aj.onreadystatechange = function(){

			if (aj.readyState == 4 && aj.status == 200) {
				document.getElementById('content').innerHTML = aj.responseText;
				document.getElementById('dashboard').className = 'nav-link active';
				document.getElementById('consultant').className = 'nav-link';
				document.getElementById('knowledge_base').className = 'nav-link';
			}
		}

		aj.open("POST","pages/dashboard.php");
		aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		aj.send("action=dashboard");
	}


	/* Consultancy Service*/
	function _consultant(){
		var aj;
		if (window.XMLHttpRequest) {
			aj = new XMLHttpRequest();
		}else{
			aj = new ActiveXObject("Microsoft.XMLHTTP");
		}

		aj.onreadystatechange = function(){

			if (aj.readyState == 4 && aj.status == 200) {
				document.getElementById('content').innerHTML = aj.responseText;
				document.getElementById('knowledge_base').className = 'nav-link';
				document.getElementById('dashboard').className = 'nav-link';
				document.getElementById('consultant').className = 'nav-link active';

			}
		}

		aj.open("POST","pages/consultants.php");
		aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		aj.send("action=consultant");
	}


	/* Knowledge Base*/
	function _knowledge_base(){
		var aj;
		if (window.XMLHttpRequest) {
			aj = new XMLHttpRequest();
		}else{
			aj = new ActiveXObject("Microsoft.XMLHTTP");
		}

		aj.onreadystatechange = function(){

			if (aj.readyState == 4 && aj.status == 200) {
				document.getElementById('content').innerHTML = aj.responseText;
				document.getElementById('dashboard').className = 'nav-link';
				document.getElementById('consultant').className = 'nav-link';
				document.getElementById('knowledge_base').className = 'nav-link active';

			}
		}

		aj.open("POST","pages/knowledge_base.php");
		aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		aj.send("action=knowledge_base");
	}


	/* Discussion Forum*/
	function _discussion_forum(){

		var aj;
		if (window.XMLHttpRequest) {
			aj = new XMLHttpRequest();
		}else{
			aj = new ActiveXObject("Microsoft.XMLHTTP");
		}

		aj.onreadystatechange = function(){

			if (aj.readyState == 4 && aj.status == 200) {
				document.getElementById('content').innerHTML = aj.responseText;
				document.getElementById('knowledge_base').className = 'nav-link';
				document.getElementById('dashboard').className = 'nav-link';
				document.getElementById('consultant').className = 'nav-link';
				document.getElementById('discussion_forum').className = 'nav-link active';

			}
		}

		aj.open("POST","pages/discussion_forum.php");
		aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		aj.send("action=discussion_forum");	
	}


	/* E-Commerce*/
	function _e_commerce(){

		var aj;
		if (window.XMLHttpRequest) {
			aj = new XMLHttpRequest();
		}else{
			aj = new ActiveXObject("Microsoft.XMLHTTP");
		}

		aj.onreadystatechange = function(){

			if (aj.readyState == 4 && aj.status == 200) {
				document.getElementById('content').innerHTML = aj.responseText;

			}
		}

		aj.open("POST","pages/e_commerce.php");
		aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		aj.send();	
	}


	/* Manage Users*/
	function _manage(){

		var aj;
		if (window.XMLHttpRequest) {
			aj = new XMLHttpRequest();
		}else{
			aj = new ActiveXObject("Microsoft.XMLHTTP");
		}

		aj.onreadystatechange = function(){

			if (aj.readyState == 4 && aj.status == 200) {
				document.getElementById('content').innerHTML = aj.responseText;
				document.getElementById('consultant').className = 'nav-link';
				document.getElementById('dashboard').className = 'nav-link';
				document.getElementById('knowledge_base').className = 'nav-link';
				document.getElementById('discussion_forum').className = 'nav-link';
				document.getElementById('manage').className = 'nav-link nav-link active';

				document.getElementById('user_active').innerHTML = document.getElementById('c');
			}
		}

		aj.open("POST","pages/manage_users.php");
		aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		aj.send("action=manage_users");
	}


	/* Chat with Consultant*/
	function chat_open(a){

		var id = a;
		var aj;
		if (window.XMLHttpRequest) {
			aj = new XMLHttpRequest();
		}else{
			aj = new ActiveXObject("Microsoft.XMLHTTP");
		}

		aj.onreadystatechange = function(){

			if (aj.readyState == 4 && aj.status == 200) {
				document.getElementById('content').innerHTML = aj.responseText;
			}
		}

		aj.open("POST","pages/consultant_chat.php");
		aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		aj.send("action=consultant_chat&id="+id);
	}



	/* Add Post*/
	function add_post(){

		var title = document.getElementById('')
		var aj;
		if (window.XMLHttpRequest) {
			aj = new XMLHttpRequest();
		}else{
			aj = new ActiveXObject("Microsoft.XMLHTTP");
		}

		aj.onreadystatechange = function(){

			if (aj.readyState == 4 && aj.status == 200) {
				document.getElementById('content').innerHTML = aj.responseText;
			}
		}

		aj.open("POST","pages/post_process.php");
		aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		aj.send("action=post_process");
	}


	

	/* Approve new User*/
	function is_approved(s,id){

		var status = s.name

		var aj;
		if (window.XMLHttpRequest) {
			aj = new XMLHttpRequest();
		}else{
			aj = new ActiveXObject("Microsoft.XMLHTTP");
		}

		aj.onreadystatechange = function(){

			if (aj.readyState == 4 && aj.status == 200) {
				// document.getElementById('msg').innerHTML = aj.responseText;
				_manage();
			}
		}

		aj.open("POST","pages/manage_users.php");
		aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		aj.send("action=update_user&id="+id+"&status="+status);
	}


	/* Active/Inactive User*/
	function active(s,id){
		var status = s.name
		// alert(status);

		var aj;
		if (window.XMLHttpRequest) {
			aj = new XMLHttpRequest();
		}else{
			aj = new ActiveXObject("Microsoft.XMLHTTP");
		}

		aj.onreadystatechange = function(){

			if (aj.readyState == 4 && aj.status == 200) {
				// document.getElementById('msg').innerHTML = aj.responseText;
				_manage();
			}
		}

		aj.open("POST","pages/manage_users.php");
		aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		aj.send("action=active_user&id="+id+"&status="+status);
		
	}


	/* Rating Consultant*/
	function _rating(){

		alert(document.getElementsByName("rate"));

		var star = 0;
		star += document.getElementById('star1').value;
		star += document.getElementById('star2').value;
		star += document.getElementById('star3').value;
		star += document.getElementById('star4').value;
		star += document.getElementById('star5').value;

		alert(star);
		var aj;
		if (window.XMLHttpRequest) {
			aj = new XMLHttpRequest();
		}else{
			aj = new ActiveXObject("Microsoft.XMLHTTP");
		}

		aj.onreadystatechange = function(){

			if (aj.readyState == 4 && aj.status == 200) {
				document.getElementById('msg').innerHTML = aj.responseText;
			}
		}

		//aj.open("POST","pages/manage_users.php");
		//aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		//aj.send("action=active_user&id="+id+"&status="+status);
		
	}



	/* Rating Consultant*/
	function _detail(a,b = 0){

		var id = a;
		var num = b;
		var aj;
		if (window.XMLHttpRequest) {
			aj = new XMLHttpRequest();
		}else{
			aj = new ActiveXObject("Microsoft.XMLHTTP");
		}

		aj.onreadystatechange = function(){

			if (aj.readyState == 4 && aj.status == 200) {
				document.getElementById('content').innerHTML = aj.responseText;
			}
		}

		aj.open("POST","pages/detail.php");
		aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		aj.send("action=detail&post_id="+id+"&num="+num);
		
	}


