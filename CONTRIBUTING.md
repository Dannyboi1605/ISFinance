# Contributing to ISFinance

Thank you for considering contributing to ISFinance! This document provides guidelines and instructions for contributing to the project.

## 📋 Table of Contents

- [Code of Conduct](#code-of-conduct)
- [Getting Started](#getting-started)
- [Development Workflow](#development-workflow)
- [Coding Standards](#coding-standards)
- [Commit Guidelines](#commit-guidelines)
- [Pull Request Process](#pull-request-process)
- [Testing](#testing)
- [Documentation](#documentation)

---

## 🤝 Code of Conduct

- Be respectful and inclusive
- Welcome newcomers and help them learn
- Focus on constructive feedback
- Respect differing viewpoints and experiences

---

## 🚀 Getting Started

### 1. Fork and Clone

```bash
# Fork the repository on GitHub
# Then clone your fork
git clone https://github.com/YOUR_USERNAME/ISFinance.git
cd ISFinance
```

### 2. Set Up Development Environment

Follow the installation instructions in [README.md](README.md)

### 3. Create a Branch

```bash
git checkout -b feature/your-feature-name
```

**Branch Naming Convention:**
- `feature/` - New features (e.g., `feature/loan-application`)
- `fix/` - Bug fixes (e.g., `fix/dashboard-loading`)
- `docs/` - Documentation updates (e.g., `docs/api-guide`)
- `refactor/` - Code refactoring (e.g., `refactor/user-service`)
- `test/` - Adding tests (e.g., `test/loan-validation`)

---

## 🔄 Development Workflow

### 1. Keep Your Fork Updated

```bash
# Add upstream remote (one time only)
git remote add upstream https://github.com/ORIGINAL_OWNER/ISFinance.git

# Fetch and merge updates
git fetch upstream
git checkout main
git merge upstream/main
```

### 2. Make Your Changes

- Write clean, readable code
- Follow the coding standards below
- Add comments for complex logic
- Update documentation if needed

### 3. Test Your Changes

```bash
# Run PHP tests
php artisan test

# Check code style
./vendor/bin/pint

# Test manually in browser
php artisan serve
npm run dev
```

### 4. Commit Your Changes

```bash
git add .
git commit -m "feat: add loan application form"
```

### 5. Push and Create PR

```bash
git push origin feature/your-feature-name
```

Then create a Pull Request on GitHub.

---

## 📝 Coding Standards

### PHP (Laravel)

- Follow **PSR-12** coding standard
- Use **type hints** for function parameters and return types
- Use **meaningful variable names** (no single letters except in loops)
- Keep functions **small and focused** (single responsibility)
- Add **PHPDoc comments** for classes and public methods

**Example:**

```php
/**
 * Approve a loan application
 *
 * @param  int  $loanId
 * @return \App\Models\Loan
 * @throws \Exception
 */
public function approveLoan(int $loanId): Loan
{
    $loan = Loan::findOrFail($loanId);
    
    if ($loan->status !== 'pending') {
        throw new \Exception('Loan is not in pending status');
    }
    
    $loan->update(['status' => 'approved']);
    
    return $loan;
}
```

### Blade Templates

- Use **semantic HTML5** elements
- Keep **logic minimal** in views
- Use **components** for reusable UI elements
- Add **comments** for major sections
- Follow **TailwindCSS** utility-first approach

**Example:**

```blade
{{-- Loan Application Card --}}
<div class="card-hover bg-white rounded-xl shadow-lg p-6">
    <h3 class="text-xl font-bold text-gray-900 mb-4">
        {{ $loan->title }}
    </h3>
    
    @if($loan->isApproved())
        <span class="badge badge-success">Approved</span>
    @else
        <span class="badge badge-warning">Pending</span>
    @endif
</div>
```

### JavaScript

- Use **ES6+** syntax
- Use **const** and **let** (no var)
- Add **comments** for complex logic
- Keep functions **pure** when possible

---

## 💬 Commit Guidelines

### Commit Message Format

```
<type>(<scope>): <subject>

<body>

<footer>
```

### Types

- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation changes
- `style`: Code formatting (no logic change)
- `refactor`: Code refactoring
- `test`: Adding or updating tests
- `chore`: Maintenance tasks

### Examples

```bash
# Good commits
git commit -m "feat(loans): add loan application form"
git commit -m "fix(dashboard): resolve stats calculation error"
git commit -m "docs(readme): update installation instructions"

# Bad commits (avoid these)
git commit -m "update"
git commit -m "fix bug"
git commit -m "changes"
```

### Detailed Commit Example

```
feat(loans): add loan approval workflow

- Add LoanApprovalController
- Create approval email notification
- Update admin dashboard with pending loans
- Add approval/rejection actions

Closes #123
```

---

## 🔍 Pull Request Process

### Before Submitting

- [ ] Code follows project coding standards
- [ ] All tests pass (`php artisan test`)
- [ ] Code is properly formatted (`./vendor/bin/pint`)
- [ ] Documentation is updated (if needed)
- [ ] Commit messages follow guidelines
- [ ] No merge conflicts with main branch

### PR Title Format

Use the same format as commit messages:

```
feat(loans): add loan application form
fix(auth): resolve login redirect issue
```

### PR Description Template

```markdown
## Description
Brief description of what this PR does

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Breaking change
- [ ] Documentation update

## Changes Made
- Change 1
- Change 2
- Change 3

## Testing
How to test these changes:
1. Step 1
2. Step 2
3. Step 3

## Screenshots (if applicable)
[Add screenshots here]

## Related Issues
Closes #123
Relates to #456
```

### Review Process

1. **Automated Checks**: CI/CD will run tests automatically
2. **Code Review**: At least one team member must review
3. **Feedback**: Address any requested changes
4. **Approval**: Once approved, maintainer will merge

---

## 🧪 Testing

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/LoanTest.php

# Run with coverage
php artisan test --coverage
```

### Writing Tests

- Write tests for **all new features**
- Test **both success and failure cases**
- Use **descriptive test names**
- Keep tests **isolated** (no dependencies)

**Example:**

```php
public function test_admin_can_approve_loan(): void
{
    $admin = User::factory()->create(['role' => 'admin']);
    $loan = Loan::factory()->create(['status' => 'pending']);
    
    $this->actingAs($admin)
        ->post(route('admin.loans.approve', $loan))
        ->assertRedirect()
        ->assertSessionHas('success');
        
    $this->assertEquals('approved', $loan->fresh()->status);
}
```

---

## 📚 Documentation

### What to Document

- **New features**: Add usage examples
- **API changes**: Update API documentation
- **Configuration**: Document new env variables
- **Breaking changes**: Clearly mark and explain

### Where to Document

- **README.md**: Installation, setup, basic usage
- **Code comments**: Complex logic, algorithms
- **PHPDoc**: All public methods and classes
- **Wiki**: Detailed guides and tutorials

---

## ❓ Questions?

If you have questions:

1. Check existing **issues** and **pull requests**
2. Read the **README.md** and **documentation**
3. Ask in **discussions** or create an **issue**

---

## 🎉 Thank You!

Your contributions make ISFinance better for everyone. We appreciate your time and effort!

---

**Happy Coding! 🚀**
