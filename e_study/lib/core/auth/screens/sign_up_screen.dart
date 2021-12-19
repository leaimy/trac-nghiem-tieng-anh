import 'package:e_study/config/themes/text_theme.dart';
import 'package:e_study/constants/app_constants.dart';
import 'package:e_study/core/auth/provider/sign_up_screen_model.dart';
import 'package:e_study/widgets/stateless/custom_input_field.dart';
import 'package:e_study/widgets/stateless/error_box.dart';
import 'package:e_study/widgets/stateless/gradient_button.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:provider/provider.dart';

class SignUpScreen extends StatelessWidget {
  const SignUpScreen({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final Size size = MediaQuery.of(context).size;

    return Scaffold(
      appBar: AppBar(
        leading: IconButton(
          icon: const FaIcon(FontAwesomeIcons.arrowLeft),
          onPressed: () {
            Navigator.pop(context);
          },
        ),
      ),
      body: ChangeNotifierProvider<SignUpScreenModel>(
        create: (_) => SignUpScreenModel(),
        builder: (context, child) {
          return Consumer<SignUpScreenModel>(builder: (context, model, child) {
            Future.delayed(Duration.zero, () {
              if (model.isSignUpSuccess != null) {
                if (model.isSignUpSuccess == true) {
                  // Navigator.pushNamed(context, Routes.onboardingScreen);
                  showErrorPopUp(context, model, size, 'Đăng ký thành công');
                } else {
                  showErrorPopUp(
                      context, model, size, 'Vui lòng nhập đẩy đủ thông tin');
                }
              }
            });
            return Padding(
              padding: const EdgeInsets.symmetric(vertical: 8, horizontal: 24),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: <Widget>[
                  SizedBox(
                    height: size.height / 24,
                    child: const Text(
                      AppConstants.signIn,
                      style: CustomTextStyle.heading1,
                    ),
                  ),
                  SizedBox(
                    height: size.height / 24,
                    child: Row(
                      children: [
                        const Text(
                          AppConstants.alreadyHave,
                          style: CustomTextStyle.heading3,
                        ),
                        GestureDetector(
                          onTap: () {
                            Navigator.pop(context);
                          },
                          child: const Text(
                            AppConstants.signIn,
                            style: CustomTextStyle.heading3BlueBold,
                          ),
                        )
                      ],
                    ),
                  ),
                  blank(),
                  CustomInputField(
                    content: AppConstants.fullname,
                    description: AppConstants.enterFullname,
                    size: size,
                    controller: model.fullname,
                  ),
                  blank(),
                  CustomInputField(
                    content: AppConstants.username,
                    description: AppConstants.enterUsername,
                    size: size,
                    controller: model.username,
                  ),
                  blank(),
                  CustomInputField(
                    content: AppConstants.password,
                    description: AppConstants.enterPassword,
                    size: size,
                    isObsecure: true,
                    controller: model.password,
                  ),
                  blank(),
                  CustomInputField(
                    content: AppConstants.confirmPassword,
                    description: AppConstants.enterConfirmPassword,
                    size: size,
                    isObsecure: true,
                    controller: model.confirmPassword,
                  ),
                  SizedBox(
                    height: size.height / 16,
                  ),
                  BaseButton(
                    content: AppConstants.signIn,
                    size: size,
                    onTap: () async {
                      model.checkInput();
                      if (!model.isError) {
                        await model.signUpDio();
                      } else {
                        showErrorPopUp(
                            context, model, size, model.errorMessage);
                      }
                    },
                  )
                ],
              ),
            );
          });
        },
      ),
    );
  }

  SizedBox blank() {
    return const SizedBox(
      height: 24,
    );
  }

  void showErrorPopUp(
      context, SignUpScreenModel model, Size size, String error) {
    showCupertinoModalPopup(
      context: context,
      builder: (_) => Center(
        child: ErrorBox(size: size, errorMessage: error),
      ),
    );
  }
}
