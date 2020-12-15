import { simulateMouseClick } from './helpers.js';

function onUpdate(id, view) {
  document.body.style.setProperty('overflow-y', 'hidden');

  let modal = document.querySelector('.gallery__content__modal');
  modal.style.setProperty('visibility', 'visible');
  modal.style.setProperty('opacity', '1');

  document.getElementById('gallery_content_modal').innerHTML = view;

  document.getElementById('edit_cancel').addEventListener('click', function(e){
    e.preventDefault();

    document.body.style.setProperty('overflow-y', 'visible');
    modal.style.setProperty('visibility', 'hidden');
    modal.style.setProperty('opacity', '0');

  });

  document.getElementById('updateForm').addEventListener('submit', function(e){
    e.preventDefault();

    let form = new FormData(document.getElementById('updateForm'));
    form.append("id", id);
    let action = this.getAttribute('action');
    
    request(action, 'POST', false, form);
  });
}

const request = (action, type, processData = false, data = null) => {
  app.request(
    {
      data,
      type,
      action,
      success: (res) => {
        const { isUpdated } = res; // .container__description-error-m   

        let update = document.getElementById('update_status');
        document.querySelector(".container__btn-submit.container__btn-submit-update").disabled = true;
        document.querySelector(".container__btn-submit-cancel.container__btn-submit-update").disabled = true;

        if(isUpdated) {          
          update.style.setProperty('visibility', 'visible');
          update.innerHTML = "Image data updated successfully";          

          window.setTimeout(function(){
            onUpdateImageResponse(update, null);
          }, 3 * 1000);

          simulateMouseClick();
        } else {
          update.classList.toggle("container__description-error-m");
          update.style.setProperty('visibility', 'visible');
          update.innerHTML = "Error, please try later";

          window.setTimeout(function(){
            onUpdateImageResponse(update, "container__description-error-m");
          }, 3 * 1000);

          simulateMouseClick();
        }
      },
      error: (res) => {
        alert(res);
      },
    },
    processData
  );
};

const onUpdateImageResponse = (update, classType) => {
  if(classType) {
    update.classList.toggle(classType);
  }
  update.style.setProperty('visibility', 'hidden');
  update.innerHTML = "";

  document.querySelector(".container__btn-submit.container__btn-submit-update").disabled = false;
  document.querySelector(".container__btn-submit-cancel.container__btn-submit-update").disabled = false;

  document.body.style.setProperty('overflow-y', 'visible');
  document.querySelector('.gallery__content__modal').style.setProperty('visibility', 'hidden');
  document.querySelector('.gallery__content__modal').style.setProperty('opacity', '0');  
};

export { onUpdate };
