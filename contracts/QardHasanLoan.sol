// SPDX-License-Identifier: MIT
pragma solidity ^0.8.19;

/**
 * @title QardHasanLoan
 * @dev Smart contract for managing Islamic Qard Hasan (interest-free) microfinance loans.
 * 
 * This contract is designed for ISFinance prototype demonstration.
 * It implements a 0% interest loan system following Islamic finance principles.
 * 
 * Key Features:
 * - Multiple loans per wallet address supported
 * - 0% interest (Qard Hasan compliance)
 * - Flexible repayment amounts
 * - On-chain loan tracking and history
 * 
 * @notice This is a SIMULATION contract for educational purposes.
 * It is not deployed on any blockchain in the current prototype.
 */
contract QardHasanLoan {
    
    // ============================================================
    // STATE VARIABLES
    // ============================================================
    
    address public admin;
    uint256 public loanCounter;
    uint256 public constant MAX_LOANS_PER_WALLET = 3;
    uint256 public constant MAX_TOTAL_DEBT = 10000 * 10**18; // RM 10,000 in wei equivalent
    
    // ============================================================
    // STRUCTS
    // ============================================================
    
    struct Loan {
        uint256 id;
        address borrower;
        uint256 amount;
        uint256 remainingBalance;
        uint256 durationMonths;
        uint256 createdAt;
        uint256 disbursedAt;
        uint256 dueDate;
        bool isActive;
        bool isCompleted;
    }
    
    struct Repayment {
        uint256 loanId;
        uint256 amount;
        uint256 paidAt;
        address payer;
    }
    
    // ============================================================
    // MAPPINGS
    // ============================================================
    
    mapping(uint256 => Loan) public loans;
    mapping(address => uint256[]) public borrowerLoans;
    mapping(uint256 => Repayment[]) public loanRepayments;
    
    // ============================================================
    // EVENTS
    // ============================================================
    
    event LoanCreated(
        uint256 indexed loanId,
        address indexed borrower,
        uint256 amount,
        uint256 durationMonths
    );
    
    event LoanDisbursed(
        uint256 indexed loanId,
        address indexed borrower,
        uint256 disbursedAt,
        uint256 dueDate
    );
    
    event RepaymentMade(
        uint256 indexed loanId,
        address indexed payer,
        uint256 amount,
        uint256 remainingBalance
    );
    
    event LoanCompleted(
        uint256 indexed loanId,
        address indexed borrower,
        uint256 completedAt
    );
    
    // ============================================================
    // MODIFIERS
    // ============================================================
    
    modifier onlyAdmin() {
        require(msg.sender == admin, "Only admin can perform this action");
        _;
    }
    
    modifier loanExists(uint256 _loanId) {
        require(loans[_loanId].id != 0, "Loan does not exist");
        _;
    }
    
    // ============================================================
    // CONSTRUCTOR
    // ============================================================
    
    constructor() {
        admin = msg.sender;
        loanCounter = 0;
    }
    
    // ============================================================
    // LOAN MANAGEMENT FUNCTIONS
    // ============================================================
    
    /**
     * @dev Creates a new loan application
     * @param _borrower Address of the borrower
     * @param _amount Loan amount in smallest unit
     * @param _durationMonths Loan duration in months
     * @return loanId The ID of the created loan
     */
    function createLoan(
        address _borrower,
        uint256 _amount,
        uint256 _durationMonths
    ) external onlyAdmin returns (uint256) {
        require(_borrower != address(0), "Invalid borrower address");
        require(_amount > 0, "Amount must be greater than 0");
        require(_durationMonths > 0, "Duration must be greater than 0");
        
        // Check max loans per wallet
        require(
            getActiveLoanCount(_borrower) < MAX_LOANS_PER_WALLET,
            "Maximum active loans reached"
        );
        
        // Check total debt limit
        require(
            getTotalDebt(_borrower) + _amount <= MAX_TOTAL_DEBT,
            "Total debt limit exceeded"
        );
        
        loanCounter++;
        
        Loan memory newLoan = Loan({
            id: loanCounter,
            borrower: _borrower,
            amount: _amount,
            remainingBalance: _amount,
            durationMonths: _durationMonths,
            createdAt: block.timestamp,
            disbursedAt: 0,
            dueDate: 0,
            isActive: false,
            isCompleted: false
        });
        
        loans[loanCounter] = newLoan;
        borrowerLoans[_borrower].push(loanCounter);
        
        emit LoanCreated(loanCounter, _borrower, _amount, _durationMonths);
        
        return loanCounter;
    }
    
    /**
     * @dev Disburses an approved loan
     * @param _loanId ID of the loan to disburse
     */
    function disburseLoan(uint256 _loanId) external onlyAdmin loanExists(_loanId) {
        Loan storage loan = loans[_loanId];
        
        require(!loan.isActive, "Loan already disbursed");
        require(!loan.isCompleted, "Loan already completed");
        
        loan.isActive = true;
        loan.disbursedAt = block.timestamp;
        loan.dueDate = block.timestamp + (loan.durationMonths * 30 days);
        
        emit LoanDisbursed(_loanId, loan.borrower, loan.disbursedAt, loan.dueDate);
    }
    
    /**
     * @dev Makes a repayment on a loan
     * @param _loanId ID of the loan
     * @param _amount Amount to repay
     * 
     * NOTE: In a real implementation, this would handle actual token transfers.
     * For simulation purposes, we only track the repayment record.
     */
    function repayLoan(uint256 _loanId, uint256 _amount) external loanExists(_loanId) {
        Loan storage loan = loans[_loanId];
        
        require(loan.isActive, "Loan is not active");
        require(!loan.isCompleted, "Loan already completed");
        require(_amount > 0, "Amount must be greater than 0");
        require(_amount <= loan.remainingBalance, "Amount exceeds remaining balance");
        
        loan.remainingBalance -= _amount;
        
        Repayment memory newRepayment = Repayment({
            loanId: _loanId,
            amount: _amount,
            paidAt: block.timestamp,
            payer: msg.sender
        });
        
        loanRepayments[_loanId].push(newRepayment);
        
        emit RepaymentMade(_loanId, msg.sender, _amount, loan.remainingBalance);
        
        // Mark as completed if fully repaid
        if (loan.remainingBalance == 0) {
            loan.isActive = false;
            loan.isCompleted = true;
            emit LoanCompleted(_loanId, loan.borrower, block.timestamp);
        }
    }
    
    // ============================================================
    // VIEW FUNCTIONS
    // ============================================================
    
    /**
     * @dev Gets all loan IDs for a borrower
     * @param _borrower Address of the borrower
     * @return Array of loan IDs
     */
    function getLoansByBorrower(address _borrower) external view returns (uint256[] memory) {
        return borrowerLoans[_borrower];
    }
    
    /**
     * @dev Gets the count of active loans for a borrower
     * @param _borrower Address of the borrower
     * @return Count of active loans
     */
    function getActiveLoanCount(address _borrower) public view returns (uint256) {
        uint256[] memory loanIds = borrowerLoans[_borrower];
        uint256 count = 0;
        
        for (uint256 i = 0; i < loanIds.length; i++) {
            if (loans[loanIds[i]].isActive && !loans[loanIds[i]].isCompleted) {
                count++;
            }
        }
        
        return count;
    }
    
    /**
     * @dev Gets the total outstanding debt for a borrower
     * @param _borrower Address of the borrower
     * @return Total debt amount
     */
    function getTotalDebt(address _borrower) public view returns (uint256) {
        uint256[] memory loanIds = borrowerLoans[_borrower];
        uint256 totalDebt = 0;
        
        for (uint256 i = 0; i < loanIds.length; i++) {
            Loan memory loan = loans[loanIds[i]];
            if (loan.isActive && !loan.isCompleted) {
                totalDebt += loan.remainingBalance;
            }
        }
        
        return totalDebt;
    }
    
    /**
     * @dev Gets repayment history for a loan
     * @param _loanId ID of the loan
     * @return Array of repayments
     */
    function getRepaymentHistory(uint256 _loanId) external view returns (Repayment[] memory) {
        return loanRepayments[_loanId];
    }
    
    /**
     * @dev Checks if a loan is overdue
     * @param _loanId ID of the loan
     * @return True if overdue, false otherwise
     */
    function isLoanOverdue(uint256 _loanId) external view loanExists(_loanId) returns (bool) {
        Loan memory loan = loans[_loanId];
        return loan.isActive && !loan.isCompleted && block.timestamp > loan.dueDate;
    }
}
