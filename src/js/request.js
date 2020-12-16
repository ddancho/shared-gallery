var app = app !== undefined ? app : {};

(function (action) {
  "use strict";

  const ajax = (req, processData) => {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {
      if (this.readyState === XMLHttpRequest.DONE) {
        if (this.status === 200) {
          const response = JSON.parse(this.response);

          req.success(response);
        } else {
          req.error("Ajax Error");
        }
      }
    };

    if (processData) {
      let data = Object.keys(req.data)
        .map((key) => key + "=" + req.data[key])
        .join("&");

      if (req.type === "GET") {
        xmlhttp.open(req.type, req.action + "?" + data);
        xmlhttp.setRequestHeader(
          "Content-Type",
          "application/x-www-form-urlencoded"
        );
        xmlhttp.send();
      } else {
        xmlhttp.open(req.type, req.action);
        xmlhttp.setRequestHeader(
          "Content-Type",
          "application/x-www-form-urlencoded"
        );
        xmlhttp.send(data);
      }
    } else {
      xmlhttp.open(req.type, req.action);
      req.data !== null ? xmlhttp.send(req.data) : xmlhttp.send();
    }
  };

  action.request = (props, processData = true) => {
    ajax(props, processData);
  };
})(app);
