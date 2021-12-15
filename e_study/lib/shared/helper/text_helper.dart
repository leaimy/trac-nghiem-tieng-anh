class TextHelper {
  static String removeAccents(String str,{ bool toLowerCase = true}) {
    // if (str == null) return '';

    if (toLowerCase) str = str.toLowerCase();
    str = str
        .replaceAll(RegExp(r'(á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ)'), 'a')
        .replaceAll(RegExp(r'(A|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ)'), 'A')
        .replaceAll(RegExp(r'đ'), 'd')
        .replaceAll(RegExp(r'Đ'), 'D')
        .replaceAll(RegExp(r'(é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ)'), 'e')
        .replaceAll(RegExp(r'(É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ)'), 'E')
        .replaceAll(RegExp(r'(í|ì|ỉ|ĩ|ị)'), 'i')
        .replaceAll(RegExp(r'(Í|Ì|Ỉ|Ĩ|Ị)'), 'I')
        .replaceAll(RegExp(r'(ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ)'), 'o')
        .replaceAll(RegExp(r'(Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ)'), 'O')
        .replaceAll(RegExp(r'(ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự)'), 'u')
        .replaceAll(RegExp(r'(Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự)'), 'U')
        .replaceAll(RegExp(r'(ý|ỳ|ỷ|ỹ|ỵ)'), 'y')
        .replaceAll(RegExp(r'(Ý|Ỳ|Ỷ|Ỹ|Ỵ)'), 'Y')
        .replaceAll(RegExp(r'[^a-zA-Z 0-9]'), '')
        .replaceAll(RegExp(r'[ ]{2,}'), ' ');
    return str;
  }
}
