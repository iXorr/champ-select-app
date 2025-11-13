(function () {
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    const formatter = new Intl.NumberFormat('ru-RU');

    function toast(message, type = 'success') {
        let holder = document.querySelector('.toast-holder');
        if (!holder) {
            holder = document.createElement('div');
            holder.className = 'toast-holder';
            document.body.appendChild(holder);
        }
        const el = document.createElement('div');
        el.className = `toast ${type}`;
        el.textContent = message;
        holder.appendChild(el);
        requestAnimationFrame(() => el.classList.add('visible'));
        setTimeout(() => {
            el.classList.remove('visible');
            el.addEventListener('transitionend', () => el.remove(), { once: true });
        }, 3000);
    }

    function request(url, options = {}) {
        if (!csrf) {
            window.location.href = '/login';
            return Promise.reject();
        }
        return fetch(url, {
            headers: {
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                ...options.headers,
            },
            credentials: 'same-origin',
            ...options,
        }).then(async response => {
            const data = await response.json().catch(() => ({}));
            if (!response.ok) {
                throw data;
            }
            return data;
        });
    }

    function updateCartUI(cart) {
        if (!cart) return;
        const totalEl = document.querySelector('[data-cart-total]');
        const countEl = document.querySelector('[data-cart-count]');
        const cartArea = document.querySelector('[data-cart-area]');
        const emptyState = document.querySelector('[data-cart-empty]');
        const submitBtn = document.querySelector('[data-order-submit]');

        if (totalEl) {
            totalEl.textContent = `${formatter.format(cart.total)} ₽`;
        }

        if (countEl) {
            countEl.textContent = `Товаров: ${cart.count}`;
        }

        if (cartArea && emptyState) {
            if (cart.count === 0) {
                cartArea.classList.add('hidden');
                emptyState.classList.remove('hidden');
                submitBtn && (submitBtn.disabled = true);
            } else {
                cartArea.classList.remove('hidden');
                emptyState.classList.add('hidden');
                submitBtn && (submitBtn.disabled = false);
            }
        }

        document.querySelectorAll('[data-cart-row]').forEach(row => {
            const id = Number(row.dataset.cartRow);
            const item = cart.items.find(i => i.id === id);
            if (!item) {
                row.remove();
                return;
            }
            const input = row.querySelector('input[type="number"]');
            const subtotalCell = row.querySelector('[data-cart-subtotal]');

            if (input) {
                input.value = item.quantity;
                input.max = item.stock;
            }

            if (subtotalCell) {
                subtotalCell.textContent = `${formatter.format(item.quantity * item.price)} ₽`;
            }
        });
    }

    function changeQuantity(cartId, quantity) {
        return request(`/cart/items/${cartId}`, {
            method: 'PATCH',
            body: JSON.stringify({ quantity }),
        }).then(data => {
            toast(data.message);
            updateCartUI(data.cart);
        }).catch(error => toast(error.message || 'Ошибка обновления', 'error'));
    }

    document.querySelectorAll('[data-add-to-cart]').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.dataset.product;
            button.disabled = true;
            request('/cart/items', {
                method: 'POST',
                body: JSON.stringify({ product_id: id, quantity: 1 }),
            }).then(data => {
                toast(data.message);
                updateCartUI(data.cart);
            }).catch(error => {
                toast(error.message || 'Не удалось добавить товар', 'error');
            }).finally(() => {
                button.disabled = false;
            });
        });
    });

    document.querySelectorAll('[data-quantity]').forEach(wrapper => {
        wrapper.addEventListener('click', event => {
            const change = Number(event.target.dataset.change);
            if (!change) return;
            const cartId = event.target.dataset.cartItem;
            const input = wrapper.querySelector('input');
            const max = Number(input?.max || Infinity);
            const next = Math.min(max, Math.max(0, Number(input.value) + change));
            changeQuantity(cartId, next);
        });

        const input = wrapper.querySelector('input');
        input?.addEventListener('change', event => {
            const cartId = wrapper.dataset.cartItem;
            if (!cartId) return;
            const max = Number(event.target.max || Infinity);
            const value = Math.min(max, Math.max(0, Number(event.target.value)));
            changeQuantity(cartId, value);
        });
    });

    document.querySelectorAll('[data-remove]').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.dataset.cartItem;
            request(`/cart/items/${id}`, { method: 'DELETE' })
                .then(data => {
                    toast(data.message);
                    updateCartUI(data.cart);
                })
                .catch(error => toast(error.message || 'Не удалось удалить товар', 'error'));
        });
    });

    document.querySelectorAll('[data-alert]').forEach(alert => {
        setTimeout(() => alert.classList.add('hidden'), 4000);
    });

    const burger = document.querySelector('[data-toggle-menu]');
    const mobileMenu = document.querySelector('[data-mobile-menu]');
    burger?.addEventListener('click', () => {
        mobileMenu?.classList.toggle('open');
    });
})();
