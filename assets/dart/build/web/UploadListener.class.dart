import 'dart:html';

class UploadListener {
  
  UploadListener() {
    
    querySelector("#upload_button")
      ..onClick.listen(clickMade);
    
    print("Dart Upload Listener initialized");
    
  }
  
  void clickMade(MouseEvent event) {
    
    print("Clicky clicky!");
    
  }
  
}