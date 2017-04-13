/*

This file contains the default configuration options for balloon tooltips.
Default options can be edited in this file or changed after the Balloon object is
initiliazed as follows:

  var balloon = new Balloon;
  balloon.fontColor   = 'black';
  balloon.fontFamily  = 'Arial, sans-serif';
  balloon.fontSize    = '12pt';
  etc...

*/

// This function adds the default configuration and also custom
// configuration sets, specified in 'case' stanzas
BalloonConfig = function(balloon, set) {
  set = set || '';

  ////////////////////////////////////////////////////////////////
  // The default "base" config applied to all balloon objects.  //
  // See http://gmod.org/wiki/Popup_Balloons#Customization for  //
  // details about config options                               //
  //                                                            //
  // values can be overriden in custom config cases (see below) //
  ////////////////////////////////////////////////////////////////
  if (!balloon.configured || set == 'SNPTipsBubble' || set == 'GBubble') { //
	balloon.fontColor          = '#333333';                     //
    balloon.fontFamily         = 'Helvetica, Arial, sans-serif';//
    balloon.fontSize           = '11pt';                        //
    balloon.minWidth           = 200;                           //
    balloon.maxWidth           = 600;                           //
    balloon.delayTime          = 400;                           //
    balloon.vOffset            = 0;                             //
    balloon.hOffset            = 0;                             //
    balloon.stem               = true;                          //
    balloon.images             = '/images/GBubble';             //
    balloon.ieImage            = 'balloon_ie.png';              //
    balloon.balloonImage       = 'balloon.png';                 //
    balloon.upLeftStem         = 'up_left.png';                 //
    balloon.downLeftStem       = 'down_left.png';               //
    balloon.upRightStem        = 'up_right.png';                //
    balloon.downRightStem      = 'down_right.png';              //
    balloon.closeButton        = 'close.png';                   //
    balloon.closeButtonWidth   = 30;                            //
    balloon.allowAJAX          = true;                          //
    balloon.allowIframes       = true;                          //
    balloon.trackCursor        = true;                          //
    balloon.shadow             = 18;                            //
    balloon.padding            = 20;                            //
    balloon.stemHeight         = 24;                            //
    balloon.stemOverlap        = 3;                             //
    balloon.vOffset            = 0;                             //
    balloon.hOffset            = 0;                             //
    balloon.opacity            = 0.95;                           //
    balloon.configured         = set || true;                   //
  }                                                             //
  ////////////////////////////////////////////////////////////////


  ////////////////////////////////////////////////////////////////
  // Custom configuration options -- Add a case below for your  //
  // config set (default sets: GBox, GPlain, and GFade)         //
  ////////////////////////////////////////////////////////////////
  switch(set) {
  case ('SNPTipsBubble') :
	  balloon.images = "chrome://snptips/content/balloon/images/SNPTipsBubble";
	  break;

  case ('GBubble') :
	  balloon.images = "chrome://snptips/content/balloon/images/GBubble";
	  break;

    // A formatted box (no background image)
    case('GBox') :
      balloon.bgColor     = 'whitesmoke';
      balloon.borderStyle = '2px solid gray';
      balloon.padding     = 5;
      balloon.shadow      = 0;
      balloon.stem        = false;
      balloon.opacity     = 0.8;
      balloon.hOffset     = 1;
      balloon.vOffset     = 1;
      balloon.allowFade   = false;
      break;

    // A simpler balloon
    case('GPlain') :
      balloon.padding     = 5;
      balloon.images      = 'chrome://snptips/content/balloon/images/GPlain';
      balloon.ieImage     = null;
      balloon.shadow      = 0;
      balloon.stemHeight  = 15;
      balloon.stemOverlap = 1;
      balloon.opacity     = 0.85;
      break;

    // The default cartoon bubble with a fade-in effect
    case('GFade') :
      balloon.allowFade   = true;
      balloon.fadeIn      = 1000;
      balloon.faedOut     = 200;
      break;
  }
}

