function delpolloption(obj) {
    obj.parentNode.parentNode.removeChild(obj.parentNode);
    //curoptions--;
}

var curnumber = 3;
var curoptions =3;

function addpolloption() {
    if(curoptions < 10) {
        var imgid = 'newpoll_'+curnumber;
        var proid = 'pollUploadProgress_'+curnumber;
        var pollstr = $('#polloption_hidden')[0].innerHTML.replace('newpoll', imgid);
        pollstr = pollstr.replace('pollUploadProgress', proid);
        $('#polloption_new')[0].outerHTML = '<p>' + pollstr + '</p>' + $('#polloption_new')[0].outerHTML;
        curoptions++;
        curnumber++;
        // addUploadEvent(imgid, proid)

    } else {
        $('polloption_new').outerHTML = '<span>已达到最大投票数'+maxoptions+'</span>';
    }
}