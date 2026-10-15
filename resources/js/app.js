import './bootstrap';
//  削除確認JavaScriptの外部ファイル化（指摘5）
document.addEventListener('DOMContentLoaded', function () {
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function (e) {
            if (!confirm('本当に削除しますか？')) {
                e.preventDefault();
            }
        });
    });
});