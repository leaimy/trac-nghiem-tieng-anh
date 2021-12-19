import 'package:e_study/config/routes/routes.dart';
import 'package:e_study/config/themes/text_theme.dart';
import 'package:e_study/constants/app_constants.dart';
import 'package:e_study/core/auth/provider/sign_in_screen_model.dart';
import 'package:e_study/widgets/stateless/custom_input_field.dart';
import 'package:e_study/widgets/stateless/error_box.dart';
import 'package:e_study/widgets/stateless/gradient_button.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:provider/provider.dart';

class SignInScreen extends StatefulWidget {
  const SignInScreen({Key? key}) : super(key: key);

  @override
  State<SignInScreen> createState() => _SignInScreenState();
}

class _SignInScreenState extends State<SignInScreen> {
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
      body: ChangeNotifierProvider<SignInScreenModel>(
        create: (_) => SignInScreenModel(),
        builder: (context, child) {
          return Consumer<SignInScreenModel>(builder: (context, model, child) {
            Future.delayed(Duration.zero, () {
              if (model.busy) {
                onLoadingStatus();
              }
              if (model.isError) {
                showErrorPopUp(context, model, size, model.errorMessage);
              }
              if (model.isLoginSuccess != null) {
                if (model.isLoginSuccess == true) {
                  Navigator.pushNamedAndRemoveUntil(context, Routes.rootScreen,
                      (Route<dynamic> route) => false);
                } else {
                  showErrorPopUp(context, model, size, 'Đăng nhập thất bại');
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
                          AppConstants.dontHaveAccount,
                          style: CustomTextStyle.heading3,
                        ),
                        GestureDetector(
                          onTap: () {
                            Navigator.pushNamed(context, Routes.signUpScreen);
                          },
                          child: const Text(
                            AppConstants.signUp,
                            style: CustomTextStyle.heading3BlueBold,
                          ),
                        )
                      ],
                    ),
                  ),
                  blank(),
                  CustomInputField(
                    content: AppConstants.username,
                    description: AppConstants.enterUsername,
                    size: size,
                    keyboardType: TextInputType.number,
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
                  SizedBox(
                    height: size.height / 16,
                  ),
                  BaseButton(
                    content: AppConstants.signIn,
                    size: size,
                    onTap: () async {
                      model.checkInput();
                      if (!model.isError) {
                        // bắt lỗi input
                        await model.signInDio();
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
      context, SignInScreenModel model, Size size, String error) {
    showCupertinoModalPopup(
      context: context,
      builder: (_) => Center(
        child: ErrorBox(
            size: size,
            errorMessage: error,
            close: () {
              model.setLoginStatus(null);
              Navigator.pop(context);
            }),
      ),
    );
  }

  void onLoadingStatus() {
    showCupertinoModalPopup(
        context: context,
        builder: (_) {
          return const Center(child: CircularProgressIndicator());
        });
  }
}
