/* 
 * This file contains functions for the main template
 */
function error(msg, timeout)
{
  $.ambiance(
  {
    message: msg,
    type: "error",
    fade: true,
    timeout: timeout ? timeout : 0 
  });
}

function info(msg, timeout)
{
  $.ambiance(
  { 
    message: msg,
    type: "success",
    fade: true,
    timeout: timeout ? timeout : 2 
  });
}

function success(msg, timeout)
{
  info(msg, timeout);
}