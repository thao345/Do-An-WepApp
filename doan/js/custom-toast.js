// Toast function
function toast({ title = "", message = "", type = "info", duration = 3000 }) {
    const main = document.getElementById("toast");
    if (main) {
      const toast = document.createElement("div");
   
      // Auto remove toast
      const autoRemoveId = setTimeout(function () {
        main.removeChild(toast);
      }, duration + 1000); // cộng 1000 vì hiệu ứng này phải mất thêm 1s để thực hiện hiệU ứng mờ dần
  
      // Remove toast when clicked
      toast.onclick = function (e) {
        if (e.target.closest(".toast__close")) { // click vào class .toast__close hoặc con của nó
          main.removeChild(toast);
          clearTimeout(autoRemoveId); // vì khi gỡ toast trước thờI gian tự nó ẩn nó sẽ tự gỡ lần nữa và gấy lỗi vì nó không còn trong dom nữa nên cần xoá timeout đi  
        }
      };
  
      const icons = {
        success: "fas fa-check-circle",
        info: "fas fa-info-circle",
        warning: "fas fa-exclamation-circle",
        error: "fas fa-exclamation-circle"
      };
      const icon = icons[type]; // nhận đúng icon qua type
      const delay = (duration / 1000).toFixed(2); // tính ra time để ẩn toast
  
      toast.classList.add("toast", `toast--${type}`);
      // hiệU ứng mờ dần mất đi sẽ kéo dài 1s , hiệU ứng mờ dần đi sẽ bắt đầu sau ${delay}s 
      toast.style.animation = `slideInLeft ease .3s, fadeOut linear 2s ${delay}s forwards`;
  
      toast.innerHTML = `
                      <div class="toast__icon">
                          <i class="${icon}"></i>
                      </div>
                      <div class="toast__body">
                          <h3 class="toast__title">${title}</h3>
                          <p class="toast__msg">${message}</p>
                      </div>
                      <div class="toast__close">
                          <i class="fas fa-times"></i> 
                      </div>
                  `;
      main.appendChild(toast); // thêm phần tử toast là con vào phần tử cha là mains 
    }
  }
  

 
