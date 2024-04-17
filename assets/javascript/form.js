jQuery(document).ready(function($) {
  getTotalSections();
  isFirstSection();
  initLastSectionBtn();
  document.querySelector(".bp-bar-fill").style.width=456/parseInt(document.querySelectorAll('.form-step').length)+"px";
  $("#blueprintdigital-form").on("submit", function(e) {
    e.preventDefault();
    var that = $(this),
      url = that.attr("action"),
      type = that.attr("method");
      if(validateBlueForm()){
        jQuery(".btn-success").val("Processing...");
        verticalSubmission(url,type)
        }else{
          jQuery(".btn-success").val("Submit");
        }
  });

  function verticalSubmission(url,type){
    $.ajax({
      url: url,
      crossDomain: true,
      headers: {
        accept: "application/json",
        "Access-Control-Allow-Origin": "*"
      },
      type: "POST",
      dataType: "json",
      data: $("#blueprintdigital-form").serialize(),
      success: function(response) {
        let responseMessageColor =
          response.status == 200
            ? 'style="color:white;"'
            : 'style="color:green;"';
        $(".success_msg").html(
          '<i class="bp-text-center" ' +
            responseMessageColor +
            " >" +
            response.message +
            "</i>"
        );
        jQuery(".bp-card").hide();
        jQuery(".success_msg").focus();
        jQuery(".bp-alert-success").show();
      },
      error: function(data) {
        var messageColor = 'style="color:white;"',
          errMessage;
        if (data.responseJSON) {
          errMessage = data.responseJSON.message;
        } else if (data.responseText) {
          errMessage = data.responseText;
        } else {
          errMessage = "Process Failed, Kindly Contact Administrator.";
        }
        $(".error_msg").html(
          '<i class="bp-text-center" ' +
            messageColor +
            " >" +
            errMessage +
            "</i>"
        );
        jQuery(".bp-card").hide();
        jQuery(".error_msg").focus();
        jQuery(".bp-alert-danger").show();
      }
    });
  }
  (function() {
    var tf = document.createElement("script");
    tf.type = "text/javascript";
    tf.async = true;
    tf.src =
      ("https:" == document.location.protocol ? "https" : "http") +
      "://api.trustedform.com/trustedform.js?field=xxTrustedFormCertUrl&ping_field=xxTrustedFormPingUrl&l=" +
      new Date().getTime() +
      Math.random();
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(tf, s);
  })();

  function getTotalSections(){
    jQuery(".bp-counter-total").html(jQuery('.form-step').length)
  }

  function incrementBarOnNext(sectionNumber){
    document.querySelector(".bp-counter-current-screen").innerHTML = sectionNumber
    document.querySelector(".bp-bar-fill").style.width=456/parseInt(document.querySelectorAll('.form-step').length)*sectionNumber+"px";
  }

  function decrementBarOnPrevious(sectionNumber){
    document.querySelector(".bp-counter-current-screen").innerHTML = sectionNumber
    document.querySelector(".bp-bar-fill").style.width=parseInt(document.querySelector(".bp-bar-fill").style.width)-456/parseInt(document.querySelectorAll('.form-step').length)+"px";
  }

  function checkForRequiredFields(stepNumber){
    var result = false
      var formElems = document.querySelector("#step-"+stepNumber).getElementsByTagName('input');
        for(let i =0;i<formElems.length;i++){
          if(formElems[i].hasAttribute('required')){
            if(formElems[i].value==''){
            formElems[i].parentElement.classList.add('bp-input-err')
            result = false
            }else{
              formElems[i].classList.remove('bp-input-err')
              result = true
            }

        }
      }
      return result;
  }
  const navigateToFormStep = (stepNumber) => {
    incrementBarOnNext(stepNumber);
    document.querySelectorAll(".form-step").forEach((formStepElement) => {
      formStepElement.classList.add("bp-d-none");
    });
    document.querySelector("#step-" + stepNumber).classList.remove("bp-d-none");
    isFirstSection();
    isLastSection();
  };

  const navigateToPreviousStep = (stepNumber) => {

    decrementBarOnPrevious(stepNumber);
    document.querySelectorAll(".form-step").forEach((formStepElement) => {
      formStepElement.classList.add("bp-d-none");
    });

    document.querySelector("#step-" + stepNumber).classList.remove("bp-d-none");
    isFirstSection();
    isLastSection();
  };
  document.querySelectorAll(".btn-navigate-form-step").forEach((formNavigationBtn,iter) => {
    formNavigationBtn.addEventListener("click", (e) => {
      const stepNumber = parseInt(formNavigationBtn.getAttribute("step_number"));
      var step_all = document.querySelectorAll('.bp-counter')
      var current_step = step_all[iter].getAttribute('step_number');
      var totalSteps = step_all[iter].getAttribute('steps');
      validateStep = parseInt(formNavigationBtn.getAttribute('current_step_btn'))

      if(checkForRequiredFields(validateStep)){

      if(current_step == totalSteps)
      {
        document.querySelector(".bp-submit-section").classList.remove('bp-d-none');
        jQuery(".btn-navigate-form-step").addClass('bp-d-none')
        // jQuery(".bp-button-container").css('display','none')
      }
        navigateToFormStep(stepNumber);

    }
    });
  });

  document.querySelectorAll(".btn-navigate-back").forEach((formNavigationBtn,iter) => {

    formNavigationBtn.addEventListener("click", (e) => {
      let stepNumber = parseInt(formNavigationBtn.getAttribute("step_number"));

      navigateToPreviousStep(stepNumber);
    });
  });

  document.querySelector(".btn-last-section").addEventListener("click",(e)=>{

      navigateToPreviousStep(jQuery(".btn-last-section").attr("current_step_btn"));
      jQuery(".bp-submit-section").addClass("bp-d-none");
      let clearBtnContainer = jQuery("#blueprintdigital-form section:visible").find(".bp-clear-btn");
  let clearBtn = jQuery("#blueprintdigital-form section:visible").find(".bp-button-container");
  clearBtnContainer.css("display","");
  clearBtn.css("display","");
    });

});

function validateBlueForm() {
  var validateResponse = false
  if (!document.querySelector("#term_and_conditions").checked) {
    document.querySelector(".bp-error-checkbox").innerHTML =
      "Kindly, check on Terms and Conditions.";
      validateResponse =  false;
  } else {
    var v = grecaptcha.getResponse();
    if (v.length == 0) {
      document.getElementById("captcha").innerHTML =
        "You can't leave Captcha Code empty";
        validateResponse =  false;
    } else {
      document.getElementById("captcha").innerHTML = "Captcha completed";
      validateResponse =  true;
    }
  }
  return validateResponse;
}

function isFirstSection(){

  var clearBtnContainer = jQuery("#blueprintdigital-form section:visible").find(".bp-clear-btn");
  var clearBtn = jQuery("#blueprintdigital-form section:visible").find(".bp-button-container");
  if(parseInt(jQuery("#blueprintdigital-form section:visible").prop("id").split("-")[1]) != 1){
    clearBtnContainer.css("display","");
    clearBtn.css("display","")
}
}

function isLastSection(){
  let clearBtnContainer = jQuery("#blueprintdigital-form section:visible").find(".bp-clear-btn");
  let clearBtn = jQuery("#blueprintdigital-form section:visible").find(".bp-button-container");


  if(parseInt(jQuery("#blueprintdigital-form section:visible").prop("id").split("-")[1]) == parseInt(jQuery('.form-step').length))
  {
    clearBtnContainer.css("display","none");
    clearBtn.css("display","none")
    jQuery(".btn-last-section").removeClass("bp-d-none");
  }
}

function initLastSectionBtn(){
jQuery(".btn-last-section").attr("current_step_btn",jQuery('.form-step').length-1).attr("step_number",jQuery('.form-step').length)
}
