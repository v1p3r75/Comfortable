(function(){
    'use scrict'
    $(document).ready(function(){
        /**
        * FileName : dash.js
        * Description : For The Dash functions
        * website : comfortable.dev
        */
    
         const settings = {
    
           API_BASEURL : "https://comfortable.dev/admin/",
    
           /* DATA ATTIBUTES */
       
           LOADVIEW_ATTRIBUTES : "cf-page",
           FOR_ATTR : "v-for",
    
           /* VIEWS */
           PAGE_CONTAINER : '#pageViewer',
           DEFAULT_PAGE : 'dash',
           LOADING_TEMPLATE : '<div class="loading position-relative w-100 h-100 bg-white text-black top-0 bottom-0" style="z-index : 10; padding: 20% 0px"><div class="w-25 text-center mx-auto"><img src="/public/admin/static/img/loader.gif" alt="loading" class="w-75 h-75"></div></div>',

       };
    
       let loadView  = function(url, model) {
           $.ajax({
               url: settings.API_BASEURL + 'view',
               type: "POST",
               data : {page : url},
               dataType: "json"
    
           }).always(function(response){
               response.status == 200 ? $(settings.PAGE_CONTAINER).html(response.responseText) : console.error(response);
           })
       };
       
       let routingManager = function(){
           $(settings.PAGE_CONTAINER).html(settings.LOADING_TEMPLATE);
           window.location.hash != '' ? loadView(window.location.hash.slice(1)) : window.location.hash = settings.DEFAULT_PAGE
           $(window).on('hashchange', (e) =>{
               $(settings.PAGE_CONTAINER).html(settings.LOADING_TEMPLATE);
               let page = window.location.hash.slice(1);
               loadView(page)
           })
       }();
    
      //  let manageHistory = function(){
      //   $(window).on('keyup', function(e){
      //       if(e.key == "Backspace"){
      //           return window.history.back()
      //       }
      //   })
      // }();

       let init = function(){
           $('.loadView').each((i,e) =>{
               $(e).click(function() {
                   let page = $(this).data(settings.LOADVIEW_ATTRIBUTES);
                   if(window.location.hash == '#' + page){
                       return false;
                   }
                   $(settings.PAGE_CONTAINER).html(settings.LOADING_TEMPLATE);
                   window.location.hash = page;
               })
           });
       }();
        window.settings = settings
        window.cfRefresh = false;
    });
    $(window).ready(function (e){$('.preview').addClass('d-none')})
})()