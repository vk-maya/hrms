$.each(resultData, function(index, row) {
    // console.log(row.user);
    const today = new Date(row.created_at);
    let usercheck = '';
    if(row.check == 'admin'){
        usercheck = 'chat-right';
    }else{
        usercheck = 'chat-left';
    }
    bodyData += `<div class="chat ${usercheck}">
                    <div class="chat-body">
                        <div class="chat-bubble">
                            <div class="chat-content">
                                <p>${row.name}</p>
                                <p></p>
                                <span class="chat-time">${today.toDateString()}</span>
                            </div>                                               
                        </div>
                    </div>
                </div>`;
});