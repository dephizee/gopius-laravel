
const sendPostComment =(target)=>{
    var mForm = new FormData(target);
    mForm.append('_token', document.querySelector('input[name=_token]').value);
    KTApp.block(target, {});
    sendPostCommentToBackEnd(mForm, target);
    target.reset();
    return false;
}

const likePost = (target)=>{
    var mForm = new FormData();
    mForm.append('_token', document.querySelector('input[name=_token]').value);
    mForm.append('post_no', target.parentElement.parentElement.parentElement.querySelector('input[name=post_no]').value);
    KTApp.block(target, {});
    sendPostLikeToBackEnd(mForm, target);
    
}

const displayComment = (target)=>{
    var comment_list = target.parentElement.parentElement.querySelector('.comment_list');
    if (comment_list.style.display == 'block') {
        comment_list.style.display = 'none';
        target.classList.remove('bg-light-primary');
    }else{
        comment_list.style.display = 'block'
        target.classList.add('bg-light-primary');
    }
}

var sendPostCommentToBackEnd = async (data, target)=>{
    await fetch(target.parentElement.querySelector('input[name=_clink]').value,
                {
                method: 'POST',
                headers: {
                  'Accept': 'application/json',
                  
                },
                body: data,
                }
        )
    .then((result)=>result.json())
    .then((resp)=>{
        if (resp.status) {
            KTApp.unblock(target);
        }
        loadComment(resp.comment_post, target);
        target.parentElement.querySelector('.comment_post_count').innerHTML = resp.comment_post_count;
        
    })
    .catch((e)=>{
        console.log(e);
        KTApp.unblockPage();
        swal.fire({
            text: "Unable to complete task",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it",
            customClass: {
                confirmButton: "btn font-weight-bold btn-light-primary"
            }
        });
    })
    ;
    
}
var sendPostLikeToBackEnd = async (data, target)=>{
    
    await fetch(target.parentElement.querySelector('input[name=_llink]').value,
                {
                method: 'POST',
                headers: {
                  'Accept': 'application/json',
                  
                },
                body: data,
                }
        )
    .then((result)=>result.json())
    .then((resp)=>{
        if (resp.status) {
            target.classList.add('bg-light-danger');
            target.classList.add('btn-icon-danger');
        }else{
            target.classList.remove('bg-light-danger');
            target.classList.remove('btn-icon-danger');
        }
        target.querySelector('span').innerHTML = resp.like_post_count;
        console.log(resp);
        KTApp.unblock(target);
        
    })
    .catch((e)=>{
        console.log(e);
        KTApp.unblockPage();
        swal.fire({
            text: "Unable to complete task",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it",
            customClass: {
                confirmButton: "btn font-weight-bold btn-light-primary"
            }
        });
    })
    ;
    
}

var loadComment = (comment_post, target)=>{
    console.log(comment_post);
    var block_ = `  <!--begin::Symbol-->
                    <div class="symbol symbol-40 symbol-light-success mr-5 mt-1">
                        <span class="symbol-label">
                            <img src="/assets/media/svg/avatars/009-boy-4.svg" class="h-75 align-self-end" alt="" />
                        </span>
                    </div>
                    <!--end::Symbol-->
                    <!--begin::Info-->
                    <div class="d-flex flex-column flex-row-fluid">
                        <!--begin::Info-->
                        <div class="d-flex align-items-center flex-wrap">
                            <a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder pr-6">${comment_post.poster}</a>
                            <span class="text-muted font-weight-normal flex-grow-1 font-size-sm">${comment_post.date}</span>
                            
                        </div>
                        <span class="text-dark-75 font-size-sm font-weight-normal pt-1">${comment_post.content}</span>
                        <!--end::Info-->
                    </div>
                    <!--end::Info-->`;
    var mDiv = document.createElement('div');
    mDiv.className = `d-flex py-5`;
    mDiv.innerHTML = block_;

    var comment_list = target.parentElement.querySelector('.comment_list');
    comment_list.insertBefore(mDiv, comment_list.firstChild);
}