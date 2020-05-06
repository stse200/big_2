function sleep(ms) {
   return new Promise(resolve => setTimeout(resolve, ms));
}

setInterval(async function(){
  $(".thinking_3").css("display", "inline-block");
  $(".thinking_3").addClass("rotated");
  await sleep(1000);
  $(".thinking_3").css("display", "none");
  $(".thinking_1").css("display", "inline-block");

  $(".thinking_3").removeClass("rotated");
  $(".thinking_1").css("display", "none");
  $(".thinking_2").css("display", "inline-block");
  await sleep(1000);
  $(".thinking_2").css("display", "none");
  $(".thinking_3").css("display", "inline-block");
}, 3000);
