function menuCollapse() {
    var y = document.getElementById('nav-bar-menu');
    if (y.className === "menu") {
      y.className += " responsive";
    } else {
      y.className = "menu";
    }
  }