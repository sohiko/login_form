# 簡易PHPログイン・登録フォーム

このリポジトリは、**PHP初心者向け**の簡易的なログインフォームおよび登録フォームを提供しています。  
PHPの基礎的な学習や、フォーム処理の流れを理解するための教材としてご利用いただけます。

## 条件・構成

1. ユーザーIDは6桁の数字です
2. パスワードリセット機能は未実装です

## 特徴

- シンプルな構成で、初心者でも理解しやすい
- ユーザー登録機能
- ログイン機能
- セッション管理によるログイン状態の保持
- 最小限のバリデーション実装

## 動作環境

- PHP 7.x 以上
- Webサーバー（例: Apache, Nginx など）
- （任意）MySQL等のデータベース（ファイルベースの場合は不要）

## 使い方

1. このリポジトリをクローンまたはダウンロードします。
2. Webサーバーの公開ディレクトリに配置します。
3. 必要に応じて、`config.php` などの設定ファイルを編集してください。
4. ブラウザで `index.php` にアクセスして動作を確認してください。

## ファイル構成

```
README.md
index.php
setting/
  └ db.php
account/
  ├ complete.php
  ├ confirm.php
  ├ forget_password.php
  ├ index.html
  └ css/
      ├ style.css
      ├ forget_password.css
      ├ pass_reset.css
      ├ confirm.css
      ├ email_check.css
      └ awaiting.css
css/
  ├ style.css
  └ root.css
img/
  └ logo.png
```
