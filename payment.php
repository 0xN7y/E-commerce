<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Methods - Gr5 Ecommarce</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="dashboard-page">


     <?php 
      require_once 'db.php';

      if (!isset($_SESSION['username'])) {
            header("Location: loginReg.php");
            exit;
        }

    ?>


    <!-- Notch -->
    <div class="notch-container">
        <div class="notch">
            <div class="notch-time">12:30</div>
            <div class="notch-icons">
                <a href="https://www.google.com/maps" 
                     class="notch-map-link" 
                     target="_blank" 
                     rel="noopener" 
                     aria-label="Open Google Maps">
                    <i class="fas fa-compass" style="color: white;"></i>
                  </a>
                <div class="notch-time">27/7</div>

            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <div class="header-left">
                <a href="index.php" class="back-btn">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <a href="index.php" class="logo">Gr5 <span>Ecommarce</span></a>
            </div>
            
            <div class="header-right">
                <button class="icon-btn" id="accountBtn">
                        <a href="my.php"><i class="far fa-user"></i></a>
                    </button>
                
        
            </div>
        </div>
    </header>

    <!-- Payment Methods -->
    <section class="payment-methods">
        <div class="container">
            <div class="payment-layout">
                            <!-- Saved Payment Methods -->
                            <div class="saved-payments">
                                <div class="section-header">
                                    <h2>Saved Payment Methods</h2>
                                    <p>Manage your payment options for faster checkout</p>
                                </div>

                                <div class="payment-cards" id="paymentCards">
                                    <!-- Credit Card 1 -->
                                    <div class="payment-card active" data-card-id="card-1">
                                        <div class="card-header">
                                            <div class="card-type">
                                                <i class="fab fa-cc-visa"></i>
                                                <span>Visa</span>
                                            </div>
                                            <div class="card-actions">
                                                
                                                <button class="btn btn-outline connect-wallet">
                                                    Connect
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-details">
                                            <div class="card-number">•••• •••• •••• ••••</div>
                                            <div class="card-info">
                                                <span class="card-holder"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                                                <span class="card-expiry">Expires day/year</span>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="default-badge">
                                                <i class="fas fa-check-circle"></i>
                                                Default Payment Method
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Credit Card 2 -->
                                    <div class="payment-card" data-card-id="card-2">
                                        <div class="card-header">
                                            <div class="card-type">
                                                <i class="fab fa-cc-mastercard"></i>
                                                <span>Mastercard</span>
                                            </div>
                                            <div class="card-actions">
                                                <button class="btn btn-outline connect-wallet">
                                                    Connect
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-details">
                                            <div class="card-number">•••• •••• •••• ••••</div>
                                            <div class="card-info">
                                                <span class="card-holder"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                                                <span class="card-expiry">Expires day/year</span>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button class="btn btn-outline btn-sm set-default" data-card-id="card-2">
                                                Set as Default
                                            </button>
                                        </div>
                                    </div>

                                    <!-- PayPal -->
                                    <div class="payment-card" data-card-id="paypal-1">
                                        <div class="card-header">
                                            <div class="card-type">
                                                <i class="fab fa-cc-paypal"></i>
                                                <span>PayPal</span>
                                            </div>
                                            <div class="card-actions">
                                                <button class="btn btn-outline connect-wallet">
                                                    Connect
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-details">
                                            <div class="card-number"><?php echo htmlspecialchars($_SESSION['email']); ?></div>
                                            <div class="card-info">
                                                <span class="card-holder">Connected Account</span>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button class="btn btn-outline btn-sm set-default" data-card-id="paypal-1">
                                                Set as Default
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Apple Pay -->
                                <div class="digital-wallet-section">
                                    <h3>Digital Wallets</h3>
                                    <div class="wallet-options">
                                        <div class="wallet-option">
                                            <div class="wallet-info">
                                                <i class="fas fa-wallet"></i>
                                                <div>
                                                    <h4>Telebirr</h4>
                                                    <p>Fast and secure payments</p>
                                                </div>
                                            </div>
                                            <button class="btn btn-outline connect-wallet" data-wallet="apple">
                                                Connect
                                            </button>
                                        </div>
                                        <div class="wallet-option">
                                            <div class="wallet-info">
                                                <i class="fab fa-apple-pay"></i>
                                                <div>
                                                    <h4>Apple Pay</h4>
                                                    <p>Fast and secure payments with Face ID</p>
                                                </div>
                                            </div>
                                            <button class="btn btn-outline connect-wallet" data-wallet="apple">
                                                Connect
                                            </button>
                                        </div>
                                        
                                        <div class="wallet-option">
                                            <div class="wallet-info">
                                                <i class="fab fa-google-pay"></i>
                                                <div>
                                                    <h4>Google Pay</h4>
                                                    <p>Quick checkout on Android devices</p>
                                                </div>
                                            </div>
                                            <button class="btn btn-outline connect-wallet" data-wallet="google">
                                                Connect
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

           

                
                <div class="add-payment-section">
                    <div class="add-payment-card">
                        <div class="card-header">
                            <h3>Add Payment Method</h3>
                        </div>

                        <div class="payment-tabs">
                            <button class="payment-tab active" data-tab="credit-card">
                                <i class="far fa-credit-card"></i>
                                Credit Card
                            </button>
                            <button class="payment-tab" data-tab="paypal">
                                <i class="fab fa-paypal"></i>
                                PayPal
                            </button>
                            <button class="payment-tab" data-tab="bank">
                                <i class="fas fa-university"></i>
                                Bank Transfer
                            </button>
                        </div>

                        <!-- Credit Card Form -->
                        <form class="payment-form active" id="creditCardForm">
                            <div class="form-group">
                                <label for="cardNumber">Card Number</label>
                                <div class="input-with-icon">
                                    <i class="far fa-credit-card"></i>
                                    <input type="text" id="cardNumber" placeholder="1234 5678 9012 3456" maxlength="19">
                                </div>
                                <div class="card-icons">
                                    <i class="fab fa-cc-visa"></i>
                                    <i class="fab fa-cc-mastercard"></i>
                                    <i class="fab fa-cc-amex"></i>
                                    <i class="fab fa-cc-discover"></i>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="expiryDate">Expiry Date</label>
                                    <input type="text" id="expiryDate" placeholder="MM/YY" maxlength="5">
                                </div>
                                <div class="form-group">
                                    <label for="cvv">CVV</label>
                                    <div class="input-with-icon">
                                        <input type="text" id="cvv" placeholder="123" maxlength="4">
                                        <button type="button" class="cvv-help" title="3-digit code on back of card">
                                            <i class="fas fa-question-circle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="cardholderName">Cardholder Name</label>
                                <input type="text" id="cardholderName" placeholder="As shown on card">
                            </div>

                            <div class="form-options">
                                <label class="checkbox">
                                    <input type="checkbox" id="setAsDefault" checked>
                                    <span class="checkmark"></span>
                                    Set as default payment method
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox" id="saveCard" checked>
                                    <span class="checkmark"></span>
                                    Save card for future purchases
                                </label>
                            </div>

                            <div class="form-security">
                                <div class="security-badge">
                                    <i class="fas fa-lock"></i>
                                    <span>Your payment info is secured with 256-bit encryption</span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-full">
                                <i class="fas fa-plus"></i>
                                Add Credit Card
                            </button>
                        </form>

                        <!-- PayPal Form -->
                        <form class="payment-form" id="paypalForm">
                            <div class="paypal-info">
                                <div class="paypal-icon">
                                    <i class="fab fa-paypal"></i>
                                </div>
                                <h4>Connect PayPal Account</h4>
                                <p>Link your PayPal account for fast and secure checkout. You'll be redirected to PayPal to complete the connection.</p>
                                
                                <div class="paypal-benefits">
                                    <div class="benefit">
                                        <i class="fas fa-shield-alt"></i>
                                        <span>Buyer Protection on all purchases</span>
                                    </div>
                                    <div class="benefit">
                                        <i class="fas fa-bolt"></i>
                                        <span>Faster checkout experience</span>
                                    </div>
                                    <div class="benefit">
                                        <i class="fas fa-globe"></i>
                                        <span>Accepted worldwide</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-options">
                                <label class="checkbox">
                                    <input type="checkbox" id="setPaypalDefault">
                                    <span class="checkmark"></span>
                                    Set as default payment method
                                </label>
                            </div>

                            <button type="button" class="btn btn-primary btn-full paypal-connect">
                                <i class="fab fa-paypal"></i>
                                Connect PayPal Account
                            </button>
                        </form>

                        <!-- Bank Transfer Form -->
                        <form class="payment-form" id="bankForm">
                            <div class="form-group">
                                <label for="accountHolder">Account Holder Name</label>
                                <input type="text" id="accountHolder" placeholder="Full name as on bank account">
                            </div>

                            <div class="form-group">
                                <label for="accountNumber">Account Number</label>
                                <input type="text" id="accountNumber" placeholder="Enter account number">
                            </div>

                            <div class="form-group">
                                <label for="routingNumber">Routing Number</label>
                                <input type="text" id="routingNumber" placeholder="9-digit routing number">
                            </div>

                            <div class="form-group">
                                <label for="bankName">Bank Name</label>
                                <input type="text" id="bankName" placeholder="Name of your bank">
                            </div>

                            <div class="form-options">
                                <label class="checkbox">
                                    <input type="checkbox" id="setBankDefault">
                                    <span class="checkmark"></span>
                                    Set as default payment method
                                </label>
                            </div>

                            <div class="form-security">
                                <div class="security-badge">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>Bank details are encrypted and securely stored</span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-full">
                                <i class="fas fa-university"></i>
                                Add Bank Account
                            </button>
                        </form>
                    </div>

                    <!-- Security Info -->
                    <div class="security-card">
                        <div class="security-header">
                            <i class="fas fa-shield-alt"></i>
                            <h4>Payment Security</h4>
                        </div>
                        <div class="security-features">
                            <div class="security-feature">
                                <i class="fas fa-lock"></i>
                                <div>
                                    <strong>Encryption</strong>
                                    <span>Bank-level security for all transactions</span>
                                </div>
                            </div>
                          
                            <div class="security-feature">
                                <i class="fas fa-bell"></i>
                                <div>
                                    <strong>Fraud Monitoring</strong>
                                    <span>24/7 suspicious activity detection</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Delete Confirmation Modal -->
    <div class="confirmation-modal" id="deleteModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Remove Payment Method</h3>
                <button class="modal-close" id="deleteModalClose">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="warning-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <p>Are you sure you want to remove this payment method? This action cannot be undone.</p>
                <div class="card-preview" id="cardPreview">
                    <!-- Card preview will be inserted here -->
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" id="cancelDelete">Cancel</button>
                <button class="btn btn-danger" id="confirmDelete">Remove Payment Method</button>
            </div>
        </div>
    </div>

    <!-- Edit Card Modal -->
    <div class="edit-modal" id="editModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit Credit Card</h3>
                <button class="modal-close" id="editModalClose">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <!-- Edit form will be inserted here -->
            </div>
        </div>
    </div>

    <script src="assets/js/app.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initializePaymentMethods();
        });

        function initializePaymentMethods() {
            // Payment Method Tabs
            const paymentTabs = document.querySelectorAll('.payment-tab');
            const paymentForms = document.querySelectorAll('.payment-form');

            paymentTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');
                    
                    // Update active tab
                    paymentTabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Show corresponding form
                    paymentForms.forEach(form => {
                        form.classList.remove('active');
                        if (form.id === targetTab + 'Form') {
                            form.classList.add('active');
                        }
                    });
                });
            });

            // Card Number Formatting
            const cardNumberInput = document.getElementById('cardNumber');
            if (cardNumberInput) {
                cardNumberInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
                    let matches = value.match(/\d{4,16}/g);
                    let match = matches && matches[0] || '';
                    let parts = [];
                    
                    for (let i = 0; i < match.length; i += 4) {
                        parts.push(match.substring(i, i + 4));
                    }
                    
                    if (parts.length) {
                        e.target.value = parts.join(' ');
                    } else {
                        e.target.value = value;
                    }
                });
            }

            // Expiry Date Formatting
            const expiryInput = document.getElementById('expiryDate');
            if (expiryInput) {
                expiryInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length >= 2) {
                        value = value.substring(0, 2) + '/' + value.substring(2, 4);
                    }
                    e.target.value = value;
                });
            }

            // Set Default Payment Method
            const setDefaultBtns = document.querySelectorAll('.set-default');
            setDefaultBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const cardId = this.getAttribute('data-card-id');
                    setDefaultPaymentMethod(cardId);
                });
            });

            // Delete Payment Method
            const deleteBtns = document.querySelectorAll('.delete-card');
            const deleteModal = document.getElementById('deleteModal');
            const cancelDelete = document.getElementById('cancelDelete');
            const confirmDelete = document.getElementById('confirmDelete');
            const deleteModalClose = document.getElementById('deleteModalClose');
            let currentCardToDelete = null;

            deleteBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const cardId = this.getAttribute('data-card-id');
                    currentCardToDelete = cardId;
                    showDeleteConfirmation(cardId);
                });
            });

            cancelDelete.addEventListener('click', closeDeleteModal);
            deleteModalClose.addEventListener('click', closeDeleteModal);
            confirmDelete.addEventListener('click', handleDelete);

            deleteModal.addEventListener('click', function(e) {
                if (e.target === deleteModal) {
                    closeDeleteModal();
                }
            });

            // Edit Payment Method
            const editBtns = document.querySelectorAll('.edit-card');
            const editModal = document.getElementById('editModal');
            const editModalClose = document.getElementById('editModalClose');

            editBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const cardId = this.getAttribute('data-card-id');
                    showEditModal(cardId);
                });
            });

            editModalClose.addEventListener('click', function() {
                editModal.style.display = 'none';
                document.body.style.overflow = '';
            });

            editModal.addEventListener('click', function(e) {
                if (e.target === editModal) {
                    editModal.style.display = 'none';
                    document.body.style.overflow = '';
                }
            });

            // Connect Digital Wallets
            const connectWalletBtns = document.querySelectorAll('.connect-wallet');
            connectWalletBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const wallet = this.getAttribute('data-wallet');
                    connectDigitalWallet(wallet);
                });
            });

            // Form Submissions
            const creditCardForm = document.getElementById('creditCardForm');
            const bankForm = document.getElementById('bankForm');

            if (creditCardForm) {
                creditCardForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    addCreditCard(this);
                });
            }

            if (bankForm) {
                bankForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    addBankAccount(this);
                });
            }

            // PayPal Connect
            const paypalConnect = document.querySelector('.paypal-connect');
            if (paypalConnect) {
                paypalConnect.addEventListener('click', function() {
                    connectPayPal();
                });
            }

            // CVV Help Tooltip
            const cvvHelp = document.querySelector('.cvv-help');
            if (cvvHelp) {
                cvvHelp.addEventListener('click', function() {
                    showNotification('CVV is the 3-digit code on the back of your card');
                });
            }
        }

        function setDefaultPaymentMethod(cardId) {
            // Remove default from all cards
            const paymentCards = document.querySelectorAll('.payment-card');
            paymentCards.forEach(card => {
                card.classList.remove('active');
                const defaultBadge = card.querySelector('.default-badge');
                const setDefaultBtn = card.querySelector('.set-default');
                
                if (defaultBadge) {
                    defaultBadge.style.display = 'none';
                }
                if (setDefaultBtn) {
                    setDefaultBtn.style.display = 'block';
                }
            });

            // Set new default
            const targetCard = document.querySelector(`[data-card-id="${cardId}"]`);
            if (targetCard) {
                targetCard.classList.add('active');
                const defaultBadge = targetCard.querySelector('.default-badge');
                const setDefaultBtn = targetCard.querySelector('.set-default');
                
                if (defaultBadge) {
                    defaultBadge.style.display = 'flex';
                }
                if (setDefaultBtn) {
                    setDefaultBtn.style.display = 'none';
                }
                
                showNotification('Default payment method updated');
            }
        }

        function showDeleteConfirmation(cardId) {
            const card = document.querySelector(`[data-card-id="${cardId}"]`);
            const cardPreview = document.getElementById('cardPreview');
            
            if (card && cardPreview) {
                const cardType = card.querySelector('.card-type span').textContent;
                const cardNumber = card.querySelector('.card-number').textContent;
                
                cardPreview.innerHTML = `
                    <div class="preview-card">
                        <i class="${card.querySelector('.card-type i').className}"></i>
                        <div>
                            <strong>${cardType}</strong>
                            <span>${cardNumber}</span>
                        </div>
                    </div>
                `;
            }
            
            deleteModal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            deleteModal.style.display = 'none';
            document.body.style.overflow = '';
            currentCardToDelete = null;
        }

        function handleDelete() {
            if (currentCardToDelete) {
                const card = document.querySelector(`[data-card-id="${currentCardToDelete}"]`);
                if (card) {
                    card.style.opacity = '0';
                    card.style.transform = 'translateX(-20px)';
                    
                    setTimeout(() => {
                        card.remove();
                        showNotification('Payment method removed');
                        closeDeleteModal();
                    }, 300);
                }
            }
        }

        function showEditModal(cardId) {
            const card = document.querySelector(`[data-card-id="${cardId}"]`);
            const modalBody = document.querySelector('#editModal .modal-body');
            
            if (card && modalBody) {
                const cardNumber = card.querySelector('.card-number').textContent;
                const expiry = card.querySelector('.card-expiry').textContent.replace('Expires ', '');
                
                modalBody.innerHTML = `
                    <form class="edit-card-form">
                        <div class="form-group">
                            <label>Card Number</label>
                            <input type="text" value="${cardNumber}" class="card-number-input" readonly>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>Expiry Date</label>
                                <input type="text" value="${expiry}" placeholder="MM/YY">
                            </div>
                            <div class="form-group">
                                <label>CVV</label>
                                <input type="text" placeholder="***" maxlength="4">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Cardholder Name</label>
                            <input type="text" value="<?php echo htmlspecialchars($_SESSION['username']); ?>">
                        </div>
                        
                        <div class="form-options">
                            <label class="checkbox">
                                <input type="checkbox" checked>
                                <span class="checkmark"></span>
                                Set as default payment method
                            </label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-full">
                            <i class="fas fa-save"></i>
                            Update Card
                        </button>
                    </form>
                `;

                // Add form submission handler
                const editForm = modalBody.querySelector('.edit-card-form');
                editForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    showNotification('Card details updated successfully');
                    editModal.style.display = 'none';
                    document.body.style.overflow = '';
                });
            }
            
            editModal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function addCreditCard(form) {
            const formData = new FormData(form);
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Simulate API call
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding Card...';
            submitBtn.disabled = true;
            
            setTimeout(() => {
                showNotification('Credit card added successfully');
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                form.reset();
                
                // In a real app, you would add the new card to the saved payments list
            }, 2000);
        }

        function addBankAccount(form) {
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verifying Account...';
            submitBtn.disabled = true;
            
            setTimeout(() => {
                showNotification('Bank account added successfully');
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                form.reset();
            }, 2000);
        }

        function connectDigitalWallet(wallet) {
            let walletName = wallet === 'apple' ? 'Apple Pay' : 'Google Pay';
            
            showNotification(`Connecting ${walletName}...`);
            
            // Simulate wallet connection
            setTimeout(() => {
                showNotification(`${walletName} connected successfully`);
                
                // Update button state
                const connectBtn = document.querySelector(`[data-wallet="${wallet}"]`);
                if (connectBtn) {
                    connectBtn.innerHTML = '<i class="fas fa-check"></i> Connected';
                    connectBtn.classList.remove('btn-outline');
                    connectBtn.classList.add('btn-primary');
                    connectBtn.disabled = true;
                }
            }, 1500);
        }

        function connectPayPal() {
            const connectBtn = document.querySelector('.paypal-connect');
            const originalText = connectBtn.innerHTML;
            
            connectBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Redirecting...';
            connectBtn.disabled = true;
            
            // Simulate PayPal connection flow
            setTimeout(() => {
                showNotification('PayPal account connected successfully');
                connectBtn.innerHTML = '<i class="fab fa-paypal"></i> Connected';
                connectBtn.disabled = true;
                
                // Update form options
                const setDefaultCheckbox = document.getElementById('setPaypalDefault');
                if (setDefaultCheckbox) {
                    setDefaultCheckbox.checked = false;
                    setDefaultCheckbox.disabled = true;
                }
            }, 2000);
        }
    </script>
</body>
</html>
